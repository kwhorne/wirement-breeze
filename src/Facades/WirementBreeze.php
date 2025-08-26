<?php

namespace Kwhorne\WirementBreezeeee\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kwhorne\WirementBreezeeee\WirementBreezeeee
 */
class WirementBreezeeee extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Kwhorne\WirementBreezeeee\WirementBreezeeee::class;
    }
}
