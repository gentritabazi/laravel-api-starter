<?php

namespace Infrastructure\Api\Controllers;

use Infrastructure\Abstracts\Controller;

class DefaultApiController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Larapi',
            'date' => date('Y-m-d'),
            'laravel_version' => app()->version()
        ];

        return $this->response($data);
    }
}
