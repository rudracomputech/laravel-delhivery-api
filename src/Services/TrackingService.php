<?php

namespace Rudracomputech\Delhivery\Services;

use Rudracomputech\Delhivery\DelhiveryClient;

class TrackingService
{
  protected DelhiveryClient $client;

  public function __construct(DelhiveryClient $client)
  {
    $this->client = $client;
  }

  /**
   * Track order by waybill number
   */
  public function trackByWaybill(string $waybill): array
  {
    $endpoint = $this->client->getConfig()['api_endpoints']['track_order'];

    return $this->client->makeRequest('GET', $endpoint, [
      'query' => [
        'waybill' => $waybill,
      ],
    ]);
  }

  /**
   * Track multiple orders
   */
  public function trackMultiple(array $waybills): array
  {
    $endpoint = $this->client->getConfig()['api_endpoints']['track_order'];

    return $this->client->makeRequest('GET', $endpoint, [
      'query' => [
        'waybill' => implode(',', $waybills),
      ],
    ]);
  }

  /**
   * Track by reference number
   */
  public function trackByReference(string $referenceNo): array
  {
    $endpoint = $this->client->getConfig()['api_endpoints']['track_order'];

    return $this->client->makeRequest('GET', $endpoint, [
      'query' => [
        'ref_ids' => $referenceNo,
      ],
    ]);
  }

  /**
   * Get latest status
   */
  public function getLatestStatus(string $waybill): ?array
  {
    $tracking = $this->trackByWaybill($waybill);

    if (!empty($tracking['ShipmentData'][0]['Shipment']['Status'])) {
      return $tracking['ShipmentData'][0]['Shipment']['Status'];
    }

    return null;
  }
}
