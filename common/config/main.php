<?php

use common\models\Provider;
use common\models\WhatsAppProvider;

return [
    'aliases'    => [
        '@bower'  => '@vendor/bower-asset',
        '@npm'    => '@vendor/npm-asset',
        '@nadzif' => '@vendor/nadzif',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'formatter'         => [
            'dateFormat'             => 'dd MMMM yyyy',
            'decimalSeparator'       => ',',
            'thousandSeparator'      => '.',
            'currencyCode'           => 'IDR',
            'numberFormatterOptions' => [
                7 => 0,
                6 => 0,
            ],
            'numberFormatterSymbols' => [
                8 => 'Rp. ',
            ]
        ],
        'cache'             => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager'       => [
            'class' => yii\rbac\DbManager::className(),
        ],
        'tokopediaProvider' => function () {
            return Provider::find()
                ->where(['type' => Provider::TYPE_TOKOPEDIA, 'status' => Provider::STATUS_ACTIVE])
                ->with('configs')->one();
        },
    ],
];
