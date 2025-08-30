<?php

namespace Rudracomputech\Delhivery;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Rudracomputech\Delhivery\Exceptions\DelhiveryException;
use Rudracomputech\Delhivery\Services\OrderService;
use Rudracomputech\Delhivery\Services\TrackingService;
use Rudracomputech\Delhivery\Services\WaybillService;
use Rudracomputech\Delhivery\Services\PickupService;
use Rudracomputech\Delhivery\Services\PinCodeService;

class DelhiveryClient
{
  protected Client $client;
  protected array $config;
  protected string $baseUrl;

  protected OrderService $orders;
  protected TrackingService $tracking;
  protected WaybillService $waybills;
  protected PickupService $pickups;
  protected PinCodeService $pinCodes;

  public function __construct(array $config)
  {
    $this->config = $config;
    $this->baseUrl = $config['base_urls'][$config['environment']]
      ?? $config['base_urls']['production'];

    $this->client = new Client([
      'base_uri' => $this->baseUrl,
      'timeout'  => $config['timeout'] ?? 30,
      'headers'  => [
        'Authorization' => 'Token ' . $config['api_token'],
        'Content-Type'  => 'application/json',
        'Accept'        => 'application/json',
      ],
    ]);

    $this->initializeServices();
  }

  /**
   * Initialize all service classes.
   */
  protected function initializeServices(): void
  {
    $this->orders   = new OrderService($this);
    $this->tracking = new TrackingService($this);
    $this->waybills = new WaybillService($this);
    $this->pickups  = new PickupService($this);
    $this->pinCodes = new PinCodeService($this);
  }

  /**
   * Accessors for services
   */
  public function orders(): OrderService
  {
    return $this->orders;
  }

  public function tracking(): TrackingService
  {
    return $this->tracking;
  }

  public function waybills(): WaybillService
  {
    return $this->waybills;
  }

  public function pickups(): PickupService
  {
    return $this->pickups;
  }

  public function pinCodes(): PinCodeService
  {
    return $this->pinCodes;
  }

  /**
   * Perform an API request with retries and logging.
   */
  public function makeRequest(string $method, string $endpoint, array $options = []): array
  {
    $retries    = 0;
    $maxRetries = $this->config['retry_times'] ?? 3;

    while ($retries < $maxRetries) {
      try {
        if ($this->config['log_enabled'] ?? true) {
          Log::info('Delhivery API Request', [
            'method'   => $method,
            'endpoint' => $endpoint,
            'options'  => $options,
          ]);
        }

        $response = $this->client->request($method, $endpoint, $options);
        $body     = json_decode($response->getBody()->getContents(), true);

        if ($this->config['log_enabled'] ?? true) {
          Log::info('Delhivery API Response', [
            'endpoint' => $endpoint,
            'response' => $body,
          ]);
        }

        return $body;
      } catch (GuzzleException $e) {
        $retries++;

        if ($retries >= $maxRetries) {
          Log::error('Delhivery API Error', [
            'endpoint' => $endpoint,
            'error'    => $e->getMessage(),
          ]);

          throw new DelhiveryException(
            'API request failed: ' . $e->getMessage(),
            $e->getCode(),
            $e
          );
        }

        sleep(1); // simple backoff
      }
    }

    throw new DelhiveryException('Max retries exceeded');
  }

  /**
   * Helpers
   */
  public function getConfig(): array
  {
    return $this->config;
  }

  public function getClient(): Client
  {
    return $this->client;
  }
}
