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
    'product/get-all'                       => 'product/get-all',
    'tokopedia/product/product-info-by-id'  => 'tokopedia/product/product-info-by-id',
    'tokopedia/product/product-info-by-sku' => 'tokopedia/product/product-info-by-sku',
    'tokopedia/product/get-variant'         => 'tokopedia/product/get-variant',

    'tokopedia/order/get-single-order' => 'tokopedia/order/get-single-order',

    'product/create'    => 'product/create',
    'product/list'      => 'product/list',
    'product/add-image' => 'product/add-image',

    'product-variant/store' => 'product-variant/store',
    'product-variant/list'  => 'product-variant/list',

    'product-bundle/store' => 'product-bundle/store',
    'product-bundle/list'  => 'product-bundle/list',

    'product-bundle-detail/store' => 'product-bundle-detail/store',
    'product-bundle-detail/list'  => 'product-bundle-detail/list',

    'product-promo/store' => 'product-promo/store',
    'product-promo/list'  => 'product-promo/list',

    'product-discount/store' => 'product-discount/store',
    'product-discount/list'  => 'product-discount/list',

    'stock-management/store'                             => 'stock-management/store',
    'stock-management/list'                              => 'stock-management/list',

//    Category
    'category/scrap'                                     => 'category/scrap',

//    SUBSCRIPTION TYPE
    'subscription-type/store'                            => 'subscription-type/store',
    'subscription-type/<id:' . $uuidPattern . '>'        => 'subscription-type/update',
    'subscription-type/list'                             => 'subscription-type/list',
    'subscription-type/delete/<id:' . $uuidPattern . '>' => 'subscription-type/delete',

    'subscription/store' => 'subscription/store',

    'marketplace/store' => 'marketplace/store',

    'shop/store' => 'shop/store',


];
