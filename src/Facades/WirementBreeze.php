<?php

namespace Kwhorne\WirementBreeze\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kwhorne\WirementBreeze\WirementBreeze
 */
class WirementBreeze extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Kwhorne\WirementBreeze\WirementBreeze::class;
    }
}
