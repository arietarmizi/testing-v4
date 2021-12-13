<?php


namespace api\controllers;


use api\actions\ListAction;
use api\components\Controller;
use api\components\FormAction;
use api\components\HttpException;
use api\components\Response;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\productvariant\StoreProductVariantForm;
use common\models\Product;
use common\models\ProductVariant;
use yii\helpers\ArrayHelper;

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
            'list2' => [
                'class'             => ListAction::class,
                'query'             => function () {
                    return ProductVariant::find()
                        ->joinWith(['product']);
                },
                'toArrayProperties' => [
                    ProductVariant::class => [
                        'id',
                        'product' => function ($model) {
                            /** @var ProductVariant $model */
                            return [
                                'id'                 => $model->productId,
                                'code'               => $model->product->code,
                                'name'               => $model->product->name,
                                'condition'          => $model->product->condition,
                                'productDescription' => $model->product->productDescription,
                                'description'        => $model->product->description,
                                'isMaster'           => $model->product->isMaster,
                            ];
                        },
                        'sku',
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
                    ]
                ],
                'apiCodeSuccess'    => 0,
                'apiCodeFailed'     => 400,
                'successMessage'    => \Yii::t('app', 'Get product variant list success'),
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