<?php

namespace Nevnetum\Linguo;

use Illuminate\Support\Facades\Facade;

class LinguoFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Linguo';
    }
}