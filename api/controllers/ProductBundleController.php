<?php


namespace api\controllers;


use api\actions\ListAction;
use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\productbundle\StoreProductBundleForm;
use common\models\ProductBundle;

class ProductBundleController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['content-type-filter'] = [
            'class'       => ContentTypeFilter::class,
            'contentType' => ContentTypeFilter::TYPE_APPLICATION_JSON,
            'only'        => [
                'store',
                'list',
            ]
        ];

        return $behaviors;
    }

    public function actions()
    {
        return [
            'store' => [
                'class'          => FormAction::className(),
                'formClass'      => StoreProductBundleForm::className(),
                'messageSuccess' => \Yii::t('app', 'Create Product Success.'),
                'messageFailed'  => \Yii::t('app', 'Create Product Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
            'list'  => [
                'class'             => ListAction::class,
                'query'             => function () {
                    return ProductBundle::find()
                        ->where([ProductBundle::tableName() . '.status' => ProductBundle::STATUS_ACTIVE])
                        ->addOrderBy([ProductBundle::tableName() . '.name' => SORT_ASC]);
                },
                'toArrayProperties' => [
                    ProductBundle::class => [
                        'name',
                        'price',
                        'description',
                        'status'
                    ],
                ],
                'apiCodeSuccess'    => 0,
                'apiCodeFailed'     => 400,
                'successMessage'    => \Yii::t('app', 'Get Product Bundle List Success'),
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