<?php

namespace KhanCode\LaravelRestBuilder\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelRestBuilder extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelrestbuilder';
    }
}
