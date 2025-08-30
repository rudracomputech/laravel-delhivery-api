<?php

namespace Rudracomputech\Delhivery\Services;

use Rudracomputech\Delhivery\DelhiveryClient;

class PinCodeService
{
  protected DelhiveryClient $client;

  public function __construct(DelhiveryClient $client)
  {
    $this->client = $client;
  }

  /**
   * Check serviceability for a pincode
   */
  public function checkServiceability(string $pinCode, string $mode = 'E'): array
  {
    $endpoint = $this->client->getConfig()['api_endpoints']['pin_check'];

    return $this->client->makeRequest('GET', $endpoint, [
      'query' => [
        'filter_codes' => $pinCode,
        'd' => $mode, // E for Express, S for Surface
      ],
    ]);
  }

  /**
   * Check COD availability
   */
  public function checkCODAvailability(string $pinCode): bool
  {
    $result = $this->checkServiceability($pinCode);

    if (!empty($result['delivery_codes'][0]['postal_code']['cod'])) {
      return $result['delivery_codes'][0]['postal_code']['cod'] === 'Y';
    }

    return false;
  }

  /**
   * Get estimated delivery time
   */
  public function getEstimatedDeliveryTime(string $originPinCode, string $destinationPinCode): ?array
  {
    $endpoint = $this->client->getConfig()['api_endpoints']['pin_check'];

    $result = $this->client->makeRequest('GET', $endpoint, [
      'query' => [
        'o' => $originPinCode,
        'd' => $destinationPinCode,
      ],
    ]);

    return $result['delivery_codes'][0] ?? null;
  }
}
