<?php

namespace api\controllers;

use api\actions\ListAction;
use api\actions\ViewAction;
use api\components\Controller;
use api\components\HttpException;
use api\components\Response;
use api\forms\NotificationForm;
use common\components\Service;
use common\helpers\FolderManager;
use common\models\Banner;
use common\models\Product;
use common\models\Production;
use GuzzleHttp\Exception\ClientException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

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
