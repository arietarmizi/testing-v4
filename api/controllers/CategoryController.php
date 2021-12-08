<?php


namespace api\controllers;


use api\components\Response;
use api\config\ApiCode;
use api\forms\category\ScrapFrom;
use api\components\Controller;
use api\components\FormAction;
use api\filters\ContentTypeFilter;
use common\models\ProductCategory;
use common\models\ProductSubCategory;
use yii\helpers\ArrayHelper;

class CategoryController extends Controller
{
    public function behaviors()
    {
        $behaviors                        = parent::behaviors();
        $behaviors['content-type-filter'] = [
            'class'       => ContentTypeFilter::class,
            'contentType' => ContentTypeFilter::TYPE_APPLICATION_JSON,
            'only'        => [
                'scrap'
            ]
        ];
        return $behaviors;
    }

    public function actions()
    {
        return [
            'scrap' => [
                'class'          => FormAction::className(),
                'formClass'      => ScrapFrom::className(),
                'messageSuccess' => \Yii::t('app', 'Scrap All Product Categories Success.'),
                'messageFailed'  => \Yii::t('app', 'Scrap All Product Categories Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
        ];
    }

    public function actionList()
    {
        $productCategory   = ProductCategory::find()
            ->joinWith(['productSubCategory'])
            ->all();
        $response          = new Response();
        $response->status  = 200;
        $response->name    = 'Get Product Category Data.';
        $response->code    = ApiCode::DEFAULT_SUCCESS_CODE;
        $response->message = \Yii::t('app', 'Get Product Category Data Success.');
        $response->data    = ArrayHelper::toArray($productCategory, [
            ProductCategory::class => [
                'id',
                'name',
                'status',
                'productSubCategory' => function ($model) {
                    /** @var ProductCategory $model */
                    return [
                        $model->getProductSubCategory()->all(),
                        'name' => $model->getProductSubCategory()->all(),
                    ];
                },
            ]
        ]);
        return $response;
    }

    public function verbs()
    {
        return [
            'scrap' => ['post']
        ];
    }
}