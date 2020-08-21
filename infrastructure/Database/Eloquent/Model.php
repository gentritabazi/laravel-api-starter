<?php

namespace Infrastructure\Database\Eloquent;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Gentritabazi01\LarapiComponents\Database\TransactionalAwareEvents;

abstract class Model extends BaseModel
{
    use TransactionalAwareEvents;
}
