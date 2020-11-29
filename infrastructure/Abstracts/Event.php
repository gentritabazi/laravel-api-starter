<?php

namespace Infrastructure\Abstracts;

use Illuminate\Queue\SerializesModels;

abstract class Event
{
    use SerializesModels;
}
