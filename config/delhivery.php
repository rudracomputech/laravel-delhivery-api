<?php
return [
  /*
    |--------------------------------------------------------------------------
    | Delhivery API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Delhivery B2C API integration
    |
    */

  'api_token' => env('DELHIVERY_API_TOKEN', ''),

  'client_name' => env('DELHIVERY_CLIENT_NAME', ''),

  'environment' => env('DELHIVERY_ENVIRONMENT', 'production'), // 'production' or 'staging'

  'base_urls' => [
    'production' => 'https://track.delhivery.com',
    'staging' => 'https://staging-express.delhivery.com',
  ],

  'api_endpoints' => [
    'create_order' => '/api/cmu/create.json',
    'track_order' => '/api/v1/packages/json/',
    'generate_waybill' => '/waybill/api/bulk/json/',
    'pickup_request' => '/fm/request/new/',
    'pin_check' => '/c/api/pin-codes/json/',
    'cancel_order' => '/api/p/edit',
    'generate_packing_slip' => '/api/p/packing_slip',
  ],

  'timeout' => env('DELHIVERY_TIMEOUT', 30),

  'retry_times' => env('DELHIVERY_RETRY_TIMES', 3),

  'log_enabled' => env('DELHIVERY_LOG_ENABLED', true),
];