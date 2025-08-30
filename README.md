# Delhivery Laravel Package

A comprehensive Laravel package for integrating with Delhivery B2C API.

## Installation

```bash
composer require rudracomputech/delhivery-laravel
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=delhivery-config
```

Add the following environment variables to your `.env` file:

```env
DELHIVERY_API_TOKEN=your_api_token_here
DELHIVERY_CLIENT_NAME=your_client_name_here
DELHIVERY_ENVIRONMENT=production
DELHIVERY_TIMEOUT=30
DELHIVERY_RETRY_TIMES=3
DELHIVERY_LOG_ENABLED=true
```

## Usage

### Creating an Order

```php
use Rudracomputech\Delhivery\Facades\Delhivery;
use Rudracomputech\Delhivery\DTOs\OrderDTO;

$order = new OrderDTO([
    'name' => 'Customer Name',
    'order' => 'ORD123456',
    'order_date' => now()->format('Y-m-d H:i:s'),
    'payment_mode' => 'Prepaid',
    'total_amount' => 1500.00,
    'billing_customer_name' => 'John Doe',
    'billing_address' => '123 Main St',
    'billing_city' => 'Mumbai',
    'billing_pincode' => '400001',
    'billing_state' => 'Maharashtra',
    'billing_country' => 'India',
    'billing_email' => 'john@example.com',
    'billing_phone' => '9876543210',
    'shipping_is_billing' => 'true',
    'weight' => 0.5,
    'length' => 10,
    'breadth' => 10,
    'height' => 10,
]);

$order->addOrderItem([
    'name' => 'Product 1',
    'sku' => 'SKU123',
    'units' => 1,
    'selling_price' => 1500,
]);

$response = Delhivery::orders()->create($order);
```

### Tracking an Order

```php
use Rudracomputech\Delhivery\Facades\Delhivery;

// Track single order
$tracking = Delhivery::tracking()->trackByWaybill('1234567890');

// Track multiple orders
$tracking = Delhivery::tracking()->trackMultiple(['1234567890', '0987654321']);

// Get latest status
$status = Delhivery::tracking()->getLatestStatus('1234567890');
```

### Generating Waybills

```php
use Rudracomputech\Delhivery\Facades\Delhivery;

// Generate single waybill
$waybill = Delhivery::waybills()->generate(1);

// Generate multiple waybills
$waybills = Delhivery::waybills()->bulkGenerate(10);
```

### Checking Pin Code Serviceability

```php
use Rudracomputech\Delhivery\Facades\Delhivery;

// Check serviceability
$serviceable = Delhivery::pinCodes()->checkServiceability('400001');

// Check COD availability
$codAvailable = Delhivery::pinCodes()->checkCODAvailability('400001');

// Get estimated delivery time
$estimate = Delhivery::pinCodes()->getEstimatedDeliveryTime('400001', '110001');
```

### Creating Pickup Request

```php
use Rudracomputech\Delhivery\Facades\Delhivery;
use Rudracomputech\Delhivery\DTOs\PickupRequestDTO;

$pickupRequest = new PickupRequestDTO([
    'pickup_location' => 'Warehouse 1',
    'pickup_time' => '14:00:00',
    'pickup_date' => now()->addDay()->format('Y-m-d'),
    'expected_package_count' => 5,
    'pickup_address' => '456 Warehouse St',
    'pickup_city' => 'Mumbai',
    'pickup_state' => 'Maharashtra',
    'pickup_pincode' => '400001',
    'pickup_phone' => '9876543210',
]);

$response = Delhivery::pickups()->createRequest($pickupRequest);
```

### Canceling an Order

```php
use Rudracomputech\Delhivery\Facades\Delhivery;

$response = Delhivery::orders()->cancel('1234567890', 'Customer requested cancellation');
```

## Error Handling

The package throws `DelhiveryException` for API errors:

```php
use Rudracomputech\Delhivery\Facades\Delhivery;
use Rudracomputech\Delhivery\Exceptions\DelhiveryException;

try {
    $tracking = Delhivery::tracking()->trackByWaybill('invalid_waybill');
} catch (DelhiveryException $e) {
    // Handle error
    $errorMessage = $e->getMessage();
    $errorDetails = $e->getErrorDetails();
}
```

## License

MIT