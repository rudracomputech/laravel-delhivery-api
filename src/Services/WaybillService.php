<?php

namespace Rudracomputech\Delhivery\Services;

use Rudracomputech\Delhivery\DelhiveryClient;

class WaybillService
{
  protected DelhiveryClient $client;

  public function __construct(DelhiveryClient $client)
  {
    $this->client = $client;
  }

  /**
   * Generate waybill numbers
   */
  public function generate(int $count = 1): array
  {
    $endpoint = $this->client->getConfig()['api_endpoints']['generate_waybill'];

    return $this->client->makeRequest('GET', $endpoint, [
      'query' => [
        'cl' => $this->client->getConfig()['client_name'],
        'count' => $count,
      ],
    ]);
  }

  /**
   * Fetch waybill numbers in bulk
   */
  public function bulkGenerate(int $count = 10): array
  {
    return $this->generate($count);
  }
}
