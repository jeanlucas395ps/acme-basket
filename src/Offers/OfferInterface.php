<?php

namespace Acme\Offers;

interface OfferInterface
{
    /**
     * @param string[] $items
     * @return float The total
     */
    public function apply(array $items): float;
}
