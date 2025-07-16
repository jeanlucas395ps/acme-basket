<?php

namespace Acme\Shipping;

interface ShippingRuleInterface
{
    public function calculate(float $subtotal): float;
}
