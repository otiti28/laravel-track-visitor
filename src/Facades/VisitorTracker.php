<?php

namespace Kitoko\VisitorTracker\Facades;

use Illuminate\Support\Facades\Facade;

class VisitorTracker extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'visitor-tracker';
    }
}
