<?php

namespace Rudracomputech\Delhivery\Services;

use Rudracomputech\Delhivery\DelhiveryClient;
use Rudracomputech\Delhivery\DTOs\OrderDTO;
use Rudracomputech\Delhivery\Exceptions\DelhiveryException;

class OrderService
{
  protected DelhiveryClient $client;

  public function __construct(DelhiveryClient $client)
  {
    $this->client = $client;
  }

  /**
   * Create a new order
   */
  public function create(OrderDTO $order): array
  {
    $endpoint = $this->client->getConfig()['api_endpoints']['create_order'];

    return $this->client->makeRequest('POST', $endpoint, [
      'json' => $order->toArray(),
    ]);
  }

  /**
   * Cancel an order
   */
  public function cancel(string $waybill, string $cancellationReason = ''): array
  {
    $endpoint = $this->client->getConfig()['api_endpoints']['cancel_order'];

    return $this->client->makeRequest('POST', $endpoint, [
      'json' => [
        'waybill' => $waybill,
        'cancellation' => true,
        'cancellation_reason' => $cancellationReason,
      ],
    ]);
  }

  /**
   * Update order details
   */
  public function update(string $waybill, array $data): array
  {
    $endpoint = $this->client->getConfig()['api_endpoints']['cancel_order'];

    $data['waybill'] = $waybill;

    return $this->client->makeRequest('POST', $endpoint, [
      'json' => $data,
    ]);
  }

  /**
   * Generate packing slip
   */
  public function generatePackingSlip(array $waybills): array
  {
    $endpoint = $this->client->getConfig()['api_endpoints']['generate_packing_slip'];

    return $this->client->makeRequest('GET', $endpoint, [
      'query' => [
        'wbns' => implode(',', $waybills),
        'pdf' => 'true',
      ],
    ]);
  }
}
