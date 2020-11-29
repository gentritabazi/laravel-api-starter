<?php

namespace Infrastructure\Abstracts;

use Illuminate\Foundation\Bus\DispatchesJobs;
use one2tek\larapi\Controllers\LaravelController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends LaravelController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
