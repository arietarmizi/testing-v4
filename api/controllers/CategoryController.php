<?php


namespace api\controllers;


use api\config\ApiCode;
use api\forms\category\ScrapFrom;
use api\components\Controller;
use api\components\FormAction;
use api\filters\ContentTypeFilter;

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

    public function verbs()
    {
        return [
            'scrap' => ['post']
        ];
    }
}