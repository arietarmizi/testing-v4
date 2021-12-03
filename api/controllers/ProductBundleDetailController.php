<?php


namespace api\controllers;


use api\actions\ListAction;
use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\productbundledetail\StoreProductBundleDetailForm;
use common\models\ProductBundleDetail;

class ProductBundleDetailController extends Controller
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
                'formClass'      => StoreProductBundleDetailForm::className(),
                'messageSuccess' => \Yii::t('app', 'Create Product Success.'),
                'messageFailed'  => \Yii::t('app', 'Create Product Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
            'list'  => [
                'class'             => ListAction::class,
                'query'             => function () {
                    return ProductBundleDetail::find()
//                        ->where([ProductBundleDetail::tableName() . '.status' => ProductBundleDetail::STATUS_ACTIVE])
                        ->addOrderBy([ProductBundleDetail::tableName() . '.id' => SORT_ASC]);
                },
                'toArrayProperties' => [
                    ProductBundleDetail::class => [
                        'productBundleId',
                        'productVariantId',
                        'quantity',
                    ],
                ],
                'apiCodeSuccess'    => 0,
                'apiCodeFailed'     => 400,
                'successMessage'    => \Yii::t('app', 'Get Product Bundle Detail List Success'),
            ]
        ];
    }

    public function verbs()
    {
        return [
            'store' => ['post'],
            'list'  => ['get'],
        ];
    }
}