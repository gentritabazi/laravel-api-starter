<?php

namespace Infrastructure\Auth\Services;

use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Application;
use Api\Users\Repositories\UserRepository;
use Infrastructure\Auth\Exceptions\InvalidCredentialsException;

class LoginService
{
    const REFRESH_TOKEN = 'refreshToken';

    private $apiConsumer;

    private $auth;

    private $cookie;

    private $db;

    private $request;

    private $userRepository;

    public function __construct(Application $app, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        $this->apiConsumer = $app->make('apiconsumer');
        $this->auth = $app->make('auth');
        $this->cookie = $app->make('cookie');
        $this->db = $app->make('db');
        $this->request = $app->make('request');
    }

    /**
     * Attempt to create an access token using user credentials.
     *
     * @param string $email
     * @param string $password
     */
    public function attemptLogin($email, $password)
    {
        $user = $this->userRepository->getWhere('email', $email)->first();

        if (is_null($user)) {
            throw new InvalidCredentialsException();
        }

        if (!Hash::check($password, $user->password)) {
            throw new InvalidCredentialsException();
        }

        return $this->proxy('password', [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'username' => $email,
            'password' => $password
        ]);
    }

    /**
     * Attempt to refresh the access token used a refresh token that
     * has been saved in a cookie.
     */
    public function attemptRefresh()
    {
        $refreshToken = $this->request->cookie(self::REFRESH_TOKEN);

        return $this->proxy('refresh_token', [
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * Proxy a request to the OAuth server.
     *
     * @param string $grantType what type of grant type should be proxied.
     * @param array $datas the data to send to the server.
     */
    public function proxy($grantType, array $datas = [])
    {
        $data = array_merge($datas, [
            'client_id'     => config('passport.password_client_id'),
            'client_secret' => config('passport.password_client_secret'),
            'grant_type'    => $grantType
        ]);

        $response = $this->apiConsumer->post('/oauth/token', $data);

        if (!$response->isSuccessful()) {
            throw new Exception($response);
        }

        $data = json_decode($response->getContent());

        // Create a refresh token cookie
        // The reason why you should save the refresh token as a HttpOnly cookie is to prevent Cross-site scripting (XSS) attacks.
        // The HttpOnly flag tells the browser that this cookie should not be accessible through javascript.
        $this->cookie->queue(
            self::REFRESH_TOKEN,
            $data->refresh_token,
            864000, // 10 days
            null,
            null,
            false,
            true // HttpOnly
        );

        return [
            'access_token' => $data->access_token,
            'expires_in' => $data->expires_in,
            'id' => $datas['id'],
            'first_name' => $datas['first_name'],
            'last_name' => $datas['last_name']
        ];
    }

    /**
     * Logs out the user. We revoke access token and refresh token.
     * Also instruct the client to forget the refresh cookie.
     */
    public function logout()
    {
        $accessToken = $this->auth->user()->token();

        $refreshToken = $this->db
            ->table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        $this->cookie->queue($this->cookie->forget(self::REFRESH_TOKEN));
    }
}
