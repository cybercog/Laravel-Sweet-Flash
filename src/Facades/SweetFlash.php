<?php

namespace DraperStudio\SweetFlash\Facades;

use Illuminate\Support\Facades\Facade;

class SweetFlash extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sweet-flash';
    }
}
