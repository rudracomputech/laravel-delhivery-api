<?php

namespace Rudracomputech\Delhivery\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Rudracomputech\Delhivery\Services\OrderService orders()
 * @method static \Rudracomputech\Delhivery\Services\TrackingService tracking()
 * @method static \Rudracomputech\Delhivery\Services\WaybillService waybills()
 * @method static \Rudracomputech\Delhivery\Services\PickupService pickups()
 * @method static \Rudracomputech\Delhivery\Services\PinCodeService pinCodes()
 * 
 * @see \Rudracomputech\Delhivery\DelhiveryClient
 */
class Delhivery extends Facade
{
  protected static function getFacadeAccessor(): string
  {
    return 'delhivery';
  }
}
