<?php

use Ramsey\Uuid\Uuid;

$uuidPattern = trim(Uuid::VALID_PATTERN, '^$');

return [
    ''                                      => 'site/index',
    'rsa'                                   => 'site/rsa',
    'encoded'                               => 'site/encoded',
    'tokopedia/shop/showcase'               => 'tokopedia/shop/showcase',

//    TOKOPEDIA PRODUCTS
    'tokopedia/product/get-all'             => 'tokopedia/product/get-all',
    'tokopedia/product/product-info-by-id'  => 'tokopedia/product/product-info-by-id',
    'tokopedia/product/product-info-by-sku' => 'tokopedia/product/product-info-by-sku',
    'tokopedia/product/get-variant'         => 'tokopedia/product/get-variant',

    'tokopedia/order/get-single-order' => 'tokopedia/order/get-single-order',
];