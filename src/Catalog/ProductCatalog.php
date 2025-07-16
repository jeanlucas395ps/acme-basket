<?php

namespace Acme\Catalog;

use Acme\Product;

class ProductCatalog
{
    /**
     * @var array<string, Product>
     */
    private array $products;

    public function __construct(array $products)
    {
        $this->products = $products;
    }

    public function get(string $code): ?Product
    {
        return $this->products[$code] ?? null;
    }
}
