<?php


namespace api\controllers;


use api\actions\ListAction;
use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\productpromo\StoreProductPromoForm;
use common\models\ProductPromo;

class ProductPromoController extends Controller
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
                'formClass'      => StoreProductPromoForm::className(),
                'messageSuccess' => \Yii::t('app', 'Create Product Promo Success.'),
                'messageFailed'  => \Yii::t('app', 'Create Product Promo Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
            'list'  => [
                'class'             => ListAction::class,
                'query'             => function () {
                    return ProductPromo::find()
//                        ->where([ProductBundleDetail::tableName() . '.status' => ProductBundleDetail::STATUS_ACTIVE])
                        ->addOrderBy([ProductPromo::tableName() . '.id' => SORT_ASC]);
                },
                'toArrayProperties' => [
                    ProductPromo::class => [
                        'productVariantId',
                        'minQuantity',
                        'maxQuantity',
                        'defaultPrice',
                    ],
                ],
                'apiCodeSuccess'    => 0,
                'apiCodeFailed'     => 400,
                'successMessage'    => \Yii::t('app', 'Get Product Promo List Success'),
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