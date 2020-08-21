<?php

namespace Infrastructure\Database\Eloquent;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Api\infrastructure\Database\Eloquent\Traits\TransactionalAwareEvents;

abstract class Model extends BaseModel
{
    use TransactionalAwareEvents;
}
