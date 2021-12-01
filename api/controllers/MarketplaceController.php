<?php


namespace api\controllers;


use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\marketplace\StoreMarketplaceForm;

class MarketplaceController extends Controller
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
                'list',
                'delete',
            ]
        ];
        return $behaviors;
    }

    public function actions()
    {
        return [
            'store' => [
                'class'          => FormAction::class,
                'formClass'      => StoreMarketplaceForm::class,
                'messageSuccess' => \Yii::t('app', 'Store Subscription Success.'),
                'messageFailed'  => \Yii::t('app', 'Store Subscription Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
        ];
    }

    public function verbs()
    {
        return [
            'store' => ['post']
        ];
    }

}