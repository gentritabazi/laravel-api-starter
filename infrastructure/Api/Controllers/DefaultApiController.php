<?php

namespace Infrastructure\Api\Controllers;

use Infrastructure\Abstracts\Controller;

class DefaultApiController extends Controller
{
    public function index()
    {
        $data = [
            'title' => config('app.name'),
            'date' => date('Y-m-d'),
            'timezone' => config('app.timezone'),
            'laravel_version' => app()->version()
        ];

        return $this->response($data);
    }
}
