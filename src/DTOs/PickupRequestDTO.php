<?php

namespace Rudracomputech\Delhivery\DTOs;

class PickupRequestDTO
{
  public string $pickup_location;
  public string $pickup_time;
  public string $pickup_date;
  public int $expected_package_count;
  public string $pickup_address;
  public string $pickup_city;
  public string $pickup_state;
  public string $pickup_pincode;
  public string $pickup_phone;

  public function __construct(array $data = [])
  {
    foreach ($data as $key => $value) {
      if (property_exists($this, $key)) {
        $this->$key = $value;
      }
    }
  }

  public function toArray(): array
  {
    $data = [];
    foreach (get_object_vars($this) as $key => $value) {
      if ($value !== null) {
        $data[$key] = $value;
      }
    }
    return $data;
  }
}
