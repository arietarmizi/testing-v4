<?php


namespace api\controllers;


use api\actions\ListAction;
use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\productdiscount\StoreProductDiscountForm;
use common\models\ProductDiscount;

class ProductDiscountController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['content-type-filter'] = [
            'class'       => ContentTypeFilter::class,
            'contentType' => ContentTypeFilter::TYPE_APPLICATION_JSON,
            'only'        => [
                'store',
                'list'
            ]
        ];
        return $behaviors;
    }

    public function actions()
    {
        return [
            'store' => [
                'class'          => FormAction::className(),
                'formClass'      => StoreProductDiscountForm::className(),
                'messageSuccess' => \Yii::t('app', 'Create Product Discount Success.'),
                'messageFailed'  => \Yii::t('app', 'Create Product Discount Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
            'list'  => [
                'class'             => ListAction::class,
                'query'             => function () {
                    return ProductDiscount::find()
//                        ->where([ProductBundleDetail::tableName() . '.status' => ProductBundleDetail::STATUS_ACTIVE])
                        ->addOrderBy([ProductDiscount::tableName() . '.id' => SORT_ASC]);
                },
                'toArrayProperties' => [
                    ProductDiscount::class => [
                        'productVariantId',
                        'discountPrice',
                        'discountPercentage',
                        'startTime',
                        'endTime',
                        'initialQuota',
                        'remainingQuota',
                        'maxOrder',
                        'slashPriceStatusId',
                        'useWarehouse',
                        'status'
                    ],
                ],
                'apiCodeSuccess'    => 0,
                'apiCodeFailed'     => 400,
                'successMessage'    => \Yii::t('app', 'Get Product Discount List Success'),
            ]
        ];
    }

    public function verbs()
    {
        return [
            'store' => ['post'],
            'list'  => ['get']
        ];
    }
}