<?php

use Ramsey\Uuid\Uuid;

$uuidPattern = trim(Uuid::VALID_PATTERN, '^$');

return [
    ''                        => 'site/index',
    'rsa'                     => 'site/rsa',
    'encoded'                 => 'site/encoded',
    'tokopedia/shop/showcase' => 'tokopedia/shop/showcase',

    'auth/register' => 'auth/register',
    'auth/login'    => 'auth/login',


    'dummy'                                 => 'dummy',


//    TOKOPEDIA PRODUCTS
    'tokopedia/product/get-all'             => 'tokopedia/product/get-all',
    'tokopedia/product/product-info-by-id'  => 'tokopedia/product/product-info-by-id',
    'tokopedia/product/product-info-by-sku' => 'tokopedia/product/product-info-by-sku',
    'tokopedia/product/get-variant'         => 'tokopedia/product/get-variant',
    'tokopedia/product/create'              => 'tokopedia/product/create',
    'product/product/list'                  => 'product/product/list',

    'tokopedia/order/get-single-order'                   => 'tokopedia/order/get-single-order',

//    Category
    'tokopedia/category/scrap'                           => 'tokopedia/category/scrap',

//    AUTH USER

//    SUBSCRIPTION TYPE
    'subscription-type/store'                            => 'subscription-type/store',
    'subscription-type/<id:' . $uuidPattern . '>'        => 'subscription-type/update',
    'subscription-type/list'                             => 'subscription-type/list',
    'subscription-type/delete/<id:' . $uuidPattern . '>' => 'subscription-type/delete',

    'subscription/store' => 'subscription/store',

    'marketplace/store' => 'marketplace/store',

    'shop/store' => 'shop/store',


];
