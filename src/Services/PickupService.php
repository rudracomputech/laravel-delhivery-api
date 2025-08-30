<?php

namespace Rudracomputech\Delhivery\Services;

use Rudracomputech\Delhivery\DelhiveryClient;
use Rudracomputech\Delhivery\DTOs\PickupRequestDTO;

class PickupService
{
  protected DelhiveryClient $client;

  public function __construct(DelhiveryClient $client)
  {
    $this->client = $client;
  }

  /**
   * Create pickup request
   */
  public function createRequest(PickupRequestDTO $pickupRequest): array
  {
    $endpoint = $this->client->getConfig()['api_endpoints']['pickup_request'];

    return $this->client->makeRequest('POST', $endpoint, [
      'json' => $pickupRequest->toArray(),
    ]);
  }

  /**
   * Cancel pickup request
   */
  public function cancelRequest(string $pickupId): array
  {
    $endpoint = $this->client->getConfig()['api_endpoints']['pickup_request'] . $pickupId . '/cancel/';

    return $this->client->makeRequest('POST', $endpoint);
  }
}
