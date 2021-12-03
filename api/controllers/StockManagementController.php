<?php


namespace api\controllers;


use api\actions\ListAction;
use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\stockmanagement\StoreStockManagementForm;
use common\models\StockManagement;

class StockManagementController extends Controller
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
                'formClass'      => StoreStockManagementForm::className(),
                'messageSuccess' => \Yii::t('app', 'Create Stock Management Success.'),
                'messageFailed'  => \Yii::t('app', 'Create Stock management Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
            'list'  => [
                'class'             => ListAction::class,
                'query'             => function () {
                    return StockManagement::find()
//                        ->where([ProductBundleDetail::tableName() . '.status' => ProductBundleDetail::STATUS_ACTIVE])
                        ->addOrderBy([StockManagement::tableName() . '.id' => SORT_ASC]);
                },
                'toArrayProperties' => [
                    StockManagement::class => [
                        'warehouseId',
                        'productVariantId',
                        'promotionStock',
                        'orderedStock',
                        'availableStock',
                        'onHandStock',
                        'stockType',
                    ],
                ],
                'apiCodeSuccess'    => 0,
                'apiCodeFailed'     => 400,
                'successMessage'    => \Yii::t('app', 'Get Stock Management List Success'),
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