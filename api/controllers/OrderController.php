<?php


namespace api\controllers;


use api\actions\ListAction;
use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\order\StoreOrderForm;
use api\forms\order\UpdateOrderForm;
use common\models\CourierInformation;
use common\models\Customer;
use common\models\Order;
use common\models\ProductDiscount;
use common\models\ProductPromo;
use common\models\Warehouse;
use yii\helpers\ArrayHelper;

class OrderController extends Controller
{
    public function behaviors()
    {
        $behaviors                        = parent::behaviors();
        $behaviors['content-type-filter'] = [
            'class'       => ContentTypeFilter::class,
            'contentType' => ContentTypeFilter::TYPE_APPLICATION_JSON,
            'only'        => [
                'store',
                'update',
            ]
        ];
        return $behaviors;
    }

    public function actions()
    {
        return [
            'store'  => [
                'class'          => FormAction::className(),
                'formClass'      => StoreOrderForm::className(),
                'messageSuccess' => \Yii::t('app', 'Create Order Success.'),
                'messageFailed'  => \Yii::t('app', 'Create Order Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
            'update' => [
                'class'          => FormAction::class,
                'formClass'      => UpdateOrderForm::class,
                'messageSuccess' => \Yii::t('app', 'Update Order Success'),
                'messageFailed'  => \Yii::t('app', 'Update Order Failed'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
                'statusSuccess'  => 200,
                'statusFailed'   => 400,
            ],
            'list'   => [
                'class'             => ListAction::class,
                'query'             => function () {
                    return Order::find()
                        ->addOrderBy([Order::tableName() . '.createdAt' => SORT_ASC]);
                },
                'toArrayProperties' => [
                    Order::class => [
                        'orderDate',
                        'refInv',
                        'customerId',
                        'courierId',
                        'warehouseId',
                        'promoId',
                        'discountId',
                        'orderStatus',
                        'customer'  => function ($model) {
                            return ArrayHelper::toArray($model->customer, [
                                Customer::class => [
                                    'customerId',
                                    'customerName',
                                    'email',
                                    'phoneNumber',
                                    'address'
                                ]
                            ]);
                        },
                        'courier'   => function ($model) {
                            return ArrayHelper::toArray($model->courier, [
                                CourierInformation::class => [
                                    'courierId',
                                    'courierName',
                                    'phoneNumber'
                                ]
                            ]);
                        },
                        'warehouse' => function ($model) {
                            return ArrayHelper::toArray($model->warehouse, [
                                Warehouse::class => [
                                    'name',
                                    'description',
                                    'address'
                                ]
                            ]);
                        },
                        'promo'     => function ($model) {
                            return ArrayHelper::toArray($model->promo, [
                                ProductPromo::class => [
                                    'minQuantity',
                                    'maxQuantity',
                                    'defaultPrice'
                                ]
                            ]);
                        },
                        'discount'  => function ($model) {
                            return ArrayHelper::toArray($model->discount, [
                                ProductDiscount::class => [
                                    'discountPrice',
                                    'discountPercentage',
                                ]
                            ]);
                        },
                        'orderStatus'
                    ]
                ],
                'apiCodeSuccess'    => 0,
                'apiCodeFailed'     => 400,
                'successMessage'    => \Yii::t('app', 'Get Order List Success'),
            ],
        ];
    }

    public function verbs()
    {
        return [
            'store'  => ['post'],
            'update' => ['post'],
            'delete' => ['post'],
            'list'   => ['get'],
        ];
    }
}