<?php


namespace api\controllers;


use api\actions\ListAction;
use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\product\AddProductImagesForm;
use api\forms\product\CreateProductForm;
use api\forms\tokopedia\product\GetAllProductsForm;
use api\forms\tokopedia\product\GetInfoByIdForm;
use api\forms\tokopedia\product\GetInfoBySkuForm;
use api\forms\tokopedia\product\GetProductVariantForm;
use common\models\Product;

class ProductController extends Controller
{
    public function behaviors()
    {
        $behaviors                        = parent::behaviors();
        $behaviors['content-type-filter'] = [
            'class'       => ContentTypeFilter::class,
            'contentType' => ContentTypeFilter::TYPE_APPLICATION_JSON,
            'only'        => [
                'create',
            ]
        ];
        return $behaviors;
    }

    public function Actions()
    {
        return [
            'create'    => [
                'class'          => FormAction::className(),
                'formClass'      => CreateProductForm::className(),
                'messageSuccess' => \Yii::t('app', 'Create Product Success.'),
                'messageFailed'  => \Yii::t('app', 'Create Product Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
            'list'      => [
                'class'             => ListAction::class,
                'query'             => function () {
                    return Product::find()
//                        ->where([Product::tableName() . '.status' => Product::STATUS_ACTIVE])
//                        ->where([Product::tableName() . '.categoryId' => Category::tableName() . '.id'])
//                        ->joinWith(['category'])
                        ->addOrderBy([Product::tableName() . '.name' => SORT_ASC]);
                },
                'toArrayProperties' => [
                    Product::class => [
                        'id',
                        'shopId',
                        'productSubCategoryId',
                        'name',
                        'condition',
                        'minOrder',
                        'productDescription',
                        'description',
                        'isMaster',
                        'status'
                    ]
                ],
                'apiCodeSuccess'    => 0,
                'apiCodeFailed'     => 400,
                'successMessage'    => \Yii::t('app', 'Get product list success'),
            ],
            'add-image' => [
                'class'          => FormAction::class,
                'formClass'      => AddProductImagesForm::class,
                'messageSuccess' => \Yii::t('app', 'Add product image success'),
                'messageFailed'  => \Yii::t('app', 'Add product image failed'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
                'statusSuccess'  => 200,
                'statusFailed'   => 400,
            ]
        ];
    }

    public function verbs()
    {
        return [
            'list'   => ['get'],
            'create' => ['post']
        ];
    }
}