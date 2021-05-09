<?php

namespace Infrastructure\Auth\Exceptions;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class InvalidCredentialsException extends UnauthorizedHttpException
{
    public function __construct($message = 'Invalid Credentials!', \Exception $previous = null, $code = 0)
    {
        parent::__construct('', $message, $previous, $code);
    }
}
