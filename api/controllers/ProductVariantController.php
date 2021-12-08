<?php


namespace api\controllers;


use api\actions\ListAction;
use api\components\Controller;
use api\components\FormAction;
use api\components\Response;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\productvariant\StoreProductVariantForm;
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
        ];
    }

    public function actionList()
    {
        $masterStatus = ProductVariant::find()
            ->joinWith(['product'])
            ->all();

        $response          = new Response();
        $response->status  = 200;
        $response->name    = 'Product Variant Data';
        $response->code    = ApiCode::DEFAULT_SUCCESS_CODE;
        $response->message = \Yii::t('app', 'Get Product Variant Success.');
        $response->data    = ArrayHelper::toArray($masterStatus, [
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
        ]);

        return $response;
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