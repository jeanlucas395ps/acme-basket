<?php

namespace Acme\Offers;

use Acme\Catalog\ProductCatalog;

class BuyOneGetOneHalfPrice implements OfferInterface
{
    private ProductCatalog $catalog;
    private string $targetCode;

    public function __construct(ProductCatalog $catalog, string $targetCode = 'R01')
    {
        $this->catalog = $catalog;
        $this->targetCode = $targetCode;
    }

    public function apply(array $items): float
    {
        $count = 0;

        foreach ($items as $code) {
            if ($code === $this->targetCode) {
                $count++;
            }
        }

        if ($count < 2) {
            return 0.0;
        }

        $product = $this->catalog->get($this->targetCode);
        if (!$product) {
            return 0.0;
        }

        $halfPrice = round($product->price / 2, 2, PHP_ROUND_HALF_UP);

        $eligibleDiscounts = intdiv($count, 2);

        return  $eligibleDiscounts * $halfPrice;
    }
}
