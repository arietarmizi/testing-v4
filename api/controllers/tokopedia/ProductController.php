<?php

namespace api\controllers\tokopedia;

use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\tokopedia\product\GetAllProductsForm;
use api\forms\tokopedia\product\GetInfoById;

class ProductController extends Controller
{
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
        return $behaviors;
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
            'get-all'        => ['post'],
            'get-info-by-id' => ['get']
        ];
    }
}
