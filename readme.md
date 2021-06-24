### Introduction

**Clean-Laravel-Api** offers you to do modern API development in Laravel. Project has also support for new versions of Laravel.

**Clean-Laravel-Api** comes included with...
* Support for [Laravel 7.0](https://github.com/gentritabazi01/Clean-Laravel-Api/tree/Laravel-7) and [Laravel 8.0](https://github.com/gentritabazi01/Clean-Laravel-Api/tree/Laravel-8).
* Laravel Passport for OAuth Authentication, including a proxy for password and refresh-token grants.
* A new directory structure optimized for separating infrastructure and domain code. Groups your controllers, models, etc. by resource-type. 
* A modern exception handler for APIs.
* A base controller class that gives sorting, filtering, eager loading and pagination for your endpoints.
* A base repository class for requesting entities from your database.
* A library for creating advanced structures of related entities.


![...](pic.png?raw=true "...")


### [This project is built with one2tek/larapi package](https://github.com/one2tek/larapi)

### Automatic Installation

```bash
git clone https://github.com/gentritabazi01/Clean-Laravel-Api && cd Clean-Laravel-Api && sh ./scripts/install.sh
```

This will:

- Create the project.
- Install the dependencies.
- Create the `.env` file in the project root.
- Generate the `APP_KEY`.
- Create a symbolic link from `public/storage` to `storage/app/public`.

Now you just need to update your `.env` file as needed and install passport (check below how to install passport).

### Manual Installation

First clone the repository.
```bash
git clone https://github.com/gentritabazi01/Clean-Laravel-Api
```

Install dependencies.

```bash
composer install
```

Copy the `.env` file an create and application key.

```
cp .env.example .env && php artisan key:generate
```

Create a symbolic link from `public/storage` to `storage/app/public`. 

```
php artisan storage:link
```

Migrate the tables.

```
php artisan migrate
```

Project comes with Passport include as the default authenticatin method. You should now install it using this command.

```
php artisan passport:install
```

Copy-paste the generated secrets and IDs into your `.env` file like so.

```
PERSONAL_CLIENT_ID=1
PERSONAL_CLIENT_SECRET=mR7k7ITv4f7DJqkwtfEOythkUAsy4GJ622hPkxe6
PASSWORD_CLIENT_ID=2
PASSWORD_CLIENT_SECRET=FJWQRS3PQj6atM6fz5f6AtDboo59toGplcuUYrKL
```

If you want to save it elsewhere or change the naming be sure to modify the LoginService in `infrastructure/Auth/Services/LoginService.php`

If you want to use docker to install composer dependencies use this [script](https://laravel.com/docs/8.x/sail#installing-composer-dependencies-for-existing-projects).

### Test installation

You can quickly test if the authentication works by creating an user using the include command.

```bash
php artisan users:add {first_name} {last_name} {email} {password}
Example: php artisan users:add Gentrit Abazi gentritabazi01@gmail.com mypassword
```

Now serve your application and try to request a token using cURL

```bash
php artisan serve
curl -X POST http://localhost:8000/login -H 'Content-Type:application/json' -d '
{
    "email":"gentritabazi01@gmail.com",
    "password":"mypassword"
}'
```

This should return a token.

```json
{"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImM0MWZiOWFjZjkyZmRiY2RhYjE0ZmEwYTFlMzMwYjBjYTEwMmRiMTA1ZGI4MmZjYzllZGUwMjRiNzI2MjA2YjRhZDU4MGZhMjUxODU2Y2RkIn0.eyJhdWQiOiIyIiwianRpIjoiYzQxZmI5YWNmOTJmZGJjZGFiMTRmYTBhMWUzMzBiMGNhMTAyZGIxMDVkYjgyZmNjOWVkZTAyNGI3MjYyMDZiNGFkNTgwZmEyNTE4NTZjZGQiLCJpYXQiOjE0ODk5NTM3MDYsIm5iZiI6MTQ4OTk1MzcwNiwiZXhwIjoxNDg5OTU0MzA2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.SmsEyCEXBiwSgl0yMcjvCxoZ2a_7D6GDJTxTs_J-6yzUeJkOofrSV7RRafO3VvUckrNqy5sGgglrwGH_HN7_lNPU6XcgaaNzbzf-g7vCSzCicJiYZVzxqJpZVwqQ4WIQrc0lYdk7suZ7hwQulOD_Z79JhBNh1KSAyo3ABWHiRjh9NR_-iAjvlCohh7nAETDeVqoMrR99m3fwQYOjdtvRBHJ8Ei-Kx3Gn1DyOXyh8eGa5-yDtj-ZVI9x66YMXlm8wk4IMA_Oh7KJISfdpoQs4fPyrGsFAxQMFp02qEW2fzKl2eesZeiIAyDGWE4StHsuY3E4jZL0P-pjv08j5W4CBP0P64gkNw_GdbxlPPA-qZUzJlc3EtjrzZ9WZq3JAKKCGy5I1jHECDOqaQ1z7axm6rmxRWmXmRGwwkne8QxfPlXsN0sm5q98mJckeqCLUuir1VPyFn5Z-B7D80-sc7Zm-7zi-awJtZUGMcHSo_yNHXjVGcbJwFk04xoIL2QzMXpOVPLaUdlBp_obCJhdzT5Bx0o5SDdK2LwgEwbMkksqmrTJ7ypoezsc3ihVQIrMelK2lNfkH_cDcVdD3ub8oFTthbA62U6atXaIADcsgTCgOtgQ2uXTIko_btjECgL35LZDd8UxiyQT3w-pDrELGDPx17DQCsIZDJ8mC1s6E0d7EPsA","expires_in":600}
```

Now try to request all users `GET /users` using the newly issued token.

```bash
curl http://localhost:8000/users -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImM0MWZiOWFjZjkyZmRiY2RhYjE0ZmEwYTFlMzMwYjBjYTEwMmRiMTA1ZGI4MmZjYzllZGUwMjRiNzI2MjA2YjRhZDU4MGZhMjUxODU2Y2RkIn0.eyJhdWQiOiIyIiwianRpIjoiYzQxZmI5YWNmOTJmZGJjZGFiMTRmYTBhMWUzMzBiMGNhMTAyZGIxMDVkYjgyZmNjOWVkZTAyNGI3MjYyMDZiNGFkNTgwZmEyNTE4NTZjZGQiLCJpYXQiOjE0ODk5NTM3MDYsIm5iZiI6MTQ4OTk1MzcwNiwiZXhwIjoxNDg5OTU0MzA2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.SmsEyCEXBiwSgl0yMcjvCxoZ2a_7D6GDJTxTs_J-6yzUeJkOofrSV7RRafO3VvUckrNqy5sGgglrwGH_HN7_lNPU6XcgaaNzbzf-g7vCSzCicJiYZVzxqJpZVwqQ4WIQrc0lYdk7suZ7hwQulOD_Z79JhBNh1KSAyo3ABWHiRjh9NR_-iAjvlCohh7nAETDeVqoMrR99m3fwQYOjdtvRBHJ8Ei-Kx3Gn1DyOXyh8eGa5-yDtj-ZVI9x66YMXlm8wk4IMA_Oh7KJISfdpoQs4fPyrGsFAxQMFp02qEW2fzKl2eesZeiIAyDGWE4StHsuY3E4jZL0P-pjv08j5W4CBP0P64gkNw_GdbxlPPA-qZUzJlc3EtjrzZ9WZq3JAKKCGy5I1jHECDOqaQ1z7axm6rmxRWmXmRGwwkne8QxfPlXsN0sm5q98mJckeqCLUuir1VPyFn5Z-B7D80-sc7Zm-7zi-awJtZUGMcHSo_yNHXjVGcbJwFk04xoIL2QzMXpOVPLaUdlBp_obCJhdzT5Bx0o5SDdK2LwgEwbMkksqmrTJ7ypoezsc3ihVQIrMelK2lNfkH_cDcVdD3ub8oFTthbA62U6atXaIADcsgTCgOtgQ2uXTIko_btjECgL35LZDd8UxiyQT3w-pDrELGDPx17DQCsIZDJ8mC1s6E0d7EPsA'
```

This should return a response like so

```json
{"users":[{"id":1,"first_name":"Gentrit","last_name":"Abazi","email":"gentritabazi01@gmail.com","name":"Gentrit Abazi"}]}
```

You can refresh a new token by requesting `POST /login/refresh` and logout using `POST /logout`.
