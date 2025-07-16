<?php

namespace Acme\Tests;

use PHPUnit\Framework\TestCase;
use Acme\Basket;
use Acme\Product;
use Acme\Catalog\ProductCatalog;
use Acme\Shipping\StandardShippingRule;
use Acme\Offers\BuyOneGetOneHalfPrice;

class BasketTest extends TestCase
{
    public function test_basket_starts_empty_and_allows_add()
    {
        $catalog = new ProductCatalog([
            'R01' => new Product('R01', 'Red Widget', 32.95)
        ]);

        $basket = new Basket($catalog);
        $this->assertEmpty($basket->items());

        $basket->add('R01');
        $this->assertCount(1, $basket->items());
    }

    public function test_applies_correct_shipping_cost()
    {
        $catalog = new ProductCatalog([
            'B01' => new Product('B01', 'Blue Widget', 7.95),
            'G01' => new Product('G01', 'Green Widget', 24.95),
        ]);

        $basket = new Basket($catalog, [new StandardShippingRule()]);

        $basket->add('B01');
        $basket->add('G01');

        $this->assertEquals(7.95 + 24.95 + 4.95, $basket->total());
    }

    public function test_applies_red_widget_half_price_offer()
    {
        $catalog = new ProductCatalog([
            'R01' => new Product('R01', 'Red Widget', 32.95),
        ]);

        $offer = new BuyOneGetOneHalfPrice($catalog);
        $basket = new Basket($catalog, [], [$offer]);

        $basket->add('R01');
        $basket->add('R01');

        $expected = round(32.95 + 32.95 / 2, 2);
        $this->assertEqualsWithDelta($expected, $basket->total(), 0.01);
    }

    public function test_combined_case_red_widget_offer_and_shipping()
    {
        $catalog = new ProductCatalog([
            'B01' => new Product('B01', 'Blue Widget', 7.95),
            'G01' => new Product('G01', 'Green Widget', 24.95),
            'R01' => new Product('R01', 'Red Widget', 32.95),
        ]);

        $shipping = new StandardShippingRule();
        $offer = new BuyOneGetOneHalfPrice($catalog);

        $basket = new Basket($catalog, [$shipping], [$offer]);

        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');

        $expected = 98.27;
        $this->assertEqualsWithDelta($expected, $basket->total(), 0.01);
    }

}
