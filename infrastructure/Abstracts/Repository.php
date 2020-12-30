<?php

namespace Infrastructure\Abstracts;

use one2tek\larapi\Database\Repository as BaseRepository;

abstract class Repository extends BaseRepository
{
    protected $sortProperty = 'id';

    protected $sortDirection = 'DESC';
}
