<?php


namespace api\controllers;


use api\actions\ListAction;
use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\productvariant\StoreProductVariantForm;
use common\models\ProductVariant;

class ProductVariantController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['content-type-filter'] = [
            'class'       => ContentTypeFilter::class,
            'contentType' => ContentTypeFilter::TYPE_APPLICATION_JSON,
            'only'        => [
                'store',
                'update',
                'delete'
            ]
        ];
        return $behaviors;
    }

    public function actions()
    {
        return [
            'store' => [
                'class'          => FormAction::className(),
                'formClass'      => StoreProductVariantForm::className(),
                'messageSuccess' => \Yii::t('app', 'Create Product Success.'),
                'messageFailed'  => \Yii::t('app', 'Create Product Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
            'list'  => [
                'class'             => ListAction::class,
                'query'             => function () {
                    return ProductVariant::find()
                        ->where([ProductVariant::tableName() . '.status' => ProductVariant::STATUS_ACTIVE])
                        ->addOrderBy([ProductVariant::tableName() . '.name' => SORT_ASC]);
                },
                'toArrayProperties' => [
                    ProductVariant::class => [
                        'sku',
                        'productId',
                        'name',
                        'isShelfLife',
                        'duration',
                        'inboundLimit',
                        'outboundLimit',
                        'minOrder',
                        'productDescription',
                        'description',
                        'defaultPrice',
                        'length',
                        'width',
                        'height',
                        'weight',
                        'barcode',
                        'isPreOrder',
                        'minPreOrderDay',
                        'discount',
                        'isWholesale',
                        'isFreeReturn',
                        'isMustInsurance',
                        'status'
                    ],
                ],
                'apiCodeSuccess'    => 0,
                'apiCodeFailed'     => 400,
                'successMessage'    => \Yii::t('app', 'Get Product Variant List Success'),
            ]
        ];
    }

    public function verbs()
    {
        return [
            'store'  => ['post'],
            'update' => ['post'],
            'delete' => ['post'],
            'list'   => ['get']
        ];
    }
}