<?php

namespace Rudracomputech\Delhivery\DTOs;

class OrderDTO
{
  public string $name;
  public string $order;
  public string $order_date;
  public string $payment_mode;
  public float $total_amount;
  public string $billing_customer_name;
  public string $billing_address;
  public string $billing_city;
  public string $billing_pincode;
  public string $billing_state;
  public string $billing_country;
  public string $billing_email;
  public string $billing_phone;
  public bool $billing_alternate_phone;
  public string $shipping_is_billing;
  public ?string $shipping_customer_name;
  public ?string $shipping_address;
  public ?string $shipping_city;
  public ?string $shipping_pincode;
  public ?string $shipping_state;
  public ?string $shipping_country;
  public ?string $shipping_email;
  public ?string $shipping_phone;
  public array $order_items = [];
  public float $sub_total;
  public int $length;
  public int $breadth;
  public int $height;
  public float $weight;

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

  public function addOrderItem(array $item): self
  {
    $this->order_items[] = $item;
    return $this;
  }
}
