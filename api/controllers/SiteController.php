<?php

namespace api\controllers;

use api\components\Controller;
use api\components\Response;

class SiteController extends Controller
{
    public function behaviors()
    {
        $behaviors                              = parent::behaviors();
        $behaviors['systemAppFilter']['except'] = ['index'];

        return $behaviors;
    }
    public function actionIndex()
    {
        $response = new Response();

        $response->name    = \Yii::$app->name;
        $response->message = 'API is running';
        $response->code    = 0;
        $response->status  = 200;
        $response->data    = 'You are accessing this endpoint from ' . \Yii::$app->request->getUserIP();

        return $response;
    }
}
