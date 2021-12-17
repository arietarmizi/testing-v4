<?php


namespace api\controllers;


use api\actions\ListAction;
use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\order\StoreOrderForm;
use api\forms\orderdetail\StoreOrderDetailForm;
use api\forms\orderdetail\UpdateOrderDetailForm;
use common\models\Order;
use common\models\OrderDetail;
use common\models\ProductVariant;
use yii\helpers\ArrayHelper;

class OrderDetailController extends Controller
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
                'formClass'      => StoreOrderDetailForm::className(),
                'messageSuccess' => \Yii::t('app', 'Create Order Detail Success.'),
                'messageFailed'  => \Yii::t('app', 'Create Order Detail Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
            'update' => [
                'class'          => FormAction::class,
                'formClass'      => UpdateOrderDetailForm::class,
                'messageSuccess' => \Yii::t('app', 'Update Order Detail Success'),
                'messageFailed'  => \Yii::t('app', 'Update Order Detail Failed'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
                'statusSuccess'  => 200,
                'statusFailed'   => 400,
            ],
            'list'   => [
                'class'             => ListAction::class,
                'query'             => function () {
                    return OrderDetail::find()
                        ->addOrderBy([OrderDetail::tableName() . '.createdAt' => SORT_ASC]);
                },
                'toArrayProperties' => [
                    OrderDetail::class => [
                        'order'          => function ($model) {
                            return ArrayHelper::toArray($model->order, [
                                Order::class => [
                                    'id',
                                    'orderDate',
                                    'refInv'
                                ]
                            ]);
                        },
                        'productVariant' => function ($model) {
                            return ArrayHelper::toArray($model->productVariant, [
                                ProductVariant::class => [
                                    'id',
                                    'name',
                                    'description',
                                    'productDescription',
                                ]
                            ]);
                        },
                        'quantity',
                        'weight',
                        'height',
                        'totalWeight',
                        'isFreeReturn',
                        'productPrice',
                        'insurancePrice',
                        'subTotalPrice',
                        'notes'
                    ]
                ],
                'apiCodeSuccess'    => 0,
                'apiCodeFailed'     => 400,
                'successMessage'    => \Yii::t('app', 'Get Order Detail list Success'),
            ]
        ];
    }

    public function verbs()
    {
        return [
            'list'   => ['get'],
            'create' => ['post'],
            'update' => ['post'],
            'delete' => ['post']
        ];
    }
}