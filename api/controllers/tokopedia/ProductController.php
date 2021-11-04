<?php

namespace api\controllers\tokopedia;

use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\tokopedia\product\GetAllProductsForm;
use api\forms\tokopedia\product\GetInfoById;
use yii\filters\Cors;

class ProductController extends Controller
{
    public static function allowedDomains()
    {
        return [
            'http://127.0.0.1/e-commerce-enabler/api/web/tokopedia/product/get-all',
        ];
    }

    public function behaviors()
    {
        $behaviors                        = parent::behaviors();
        $behaviors['content-type-filter'] = [
            'class'       => ContentTypeFilter::class,
            'contentType' => ContentTypeFilter::TYPE_APPLICATION_JSON,
            'only'        => [
                'get-all',
                'get-info-by-id'
            ]
        ];

//        return $behaviors;
        return array_merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => Cors::className(),
                'cors'  => [
                    // restrict access to domains:
                    'Access-Control-Allow-Origin'      => ["*"],
                    'Access-Control-Request-Method'    => ['POST', 'GET'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 3600,
                ],
            ],
        ]);
    }

    public function Actions()
    {
        return [
            'get-all'        => [
                'class'          => FormAction::className(),
                'formClass'      => GetAllProductsForm::className(),
                'messageSuccess' => \Yii::t('app', 'Get All Products Success.'),
                'messageFailed'  => \Yii::t('app', 'Get All Products Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
            'get-info-by-id' => [
                'class'          => FormAction::className(),
                'formClass'      => GetInfoById::className(),
                'messageSuccess' => \Yii::t('app', 'Get Info Products By ID Success.'),
                'messageFailed'  => \Yii::t('app', 'Get Info Products By ID Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ]
        ];
    }

    public function verbs()
    {
        return [
            'get-all'        => ['get'],
            'get-info-by-id' => ['get']
        ];
    }
}
