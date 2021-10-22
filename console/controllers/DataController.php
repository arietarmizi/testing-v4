<?php
/**
 * Created by PhpStorm.
 * User: Nadzif Glovory
 * Date: 8/22/2018
 * Time: 6:20 PM
 */

namespace console\controllers;


use console\base\DataMigrator;
use yii\console\Controller;

class DataController extends Controller
{


    public function actions()
    {
        if (\Yii::$app->params['consoleData']) {
            return parent::actions();
        }

        return null;
    }

    public function actionRegion()
    {
        $migrator = new DataMigrator([
            'csvPath'        => __DIR__ . '/data/region.csv',
            'modelClass'     => null,
            'attributeIndex' => ['id', 'name'],
        ]);

        $migrator->migrate();
    }

}