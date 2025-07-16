<?php

namespace Acme;

use Acme\Catalog\ProductCatalog;
use Acme\Shipping\ShippingRuleInterface;
use Acme\Offers\OfferInterface;

class Basket
{
    private ProductCatalog $catalog;
    private array $shippingRules;
    private array $offers;
    private array $items = [];

    public function __construct(
        ProductCatalog $catalog,
        array $shippingRules = [],
        array $offers = []
    ) {
        $this->catalog = $catalog;
        $this->shippingRules = $shippingRules;
        $this->offers = $offers;
    }

    public function add(string $productCode): void
    {
        $this->items[] = $productCode;
    }

    public function total(): float
    {
        $subtotal = 0.0;

        foreach ($this->items as $code) {
            $product = $this->catalog->get($code);
            if ($product) {
                $subtotal += $product->price;
            }
        }

        $totalDiscount = 0.0;

        foreach ($this->offers as $offer) {
            $totalDiscount += $offer->apply($this->items);
        }

        $discountedSubtotal = $subtotal - $totalDiscount;

        $shippingCost = 0.0;

        foreach ($this->shippingRules as $rule) {
            $shippingCost += $rule->calculate($discountedSubtotal);
        }

        return round($discountedSubtotal + $shippingCost + 0.00001, 2, PHP_ROUND_HALF_UP);
        
    }

    public function items(): array
    {
        return $this->items;
    }
}
