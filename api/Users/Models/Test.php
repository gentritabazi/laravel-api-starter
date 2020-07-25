<?php

namespace Api\Users\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Test extends Authenticatable
{
    protected $table = 'test';

    use HasApiTokens, Notifiable;
}
