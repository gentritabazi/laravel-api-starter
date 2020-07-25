<?php

namespace Infrastructure\Api\Controllers;

use Infrastructure\Http\Controller as BaseController;

class DefaultApiController extends BaseController
{
    public function index()
    {
        return $this->response(['title' => 'Larapi', 'date' => date('Y-m-d'), 'laravel_version' => app()->version()]);
    }
}
