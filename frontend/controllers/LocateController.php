<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 15:57
 */

namespace frontend\controllers;


use frontend\models\Locate;
use yii\web\Controller;

class LocateController extends Controller
{
    public $layout='locate';

    public function actionIndex(){

        $model = new Locate();
        if($model->load(\yii::$app->request->post()) && $model->validate()){
            $model->save();
        }

        return $this->render('index',['model'=>$model]);
    }
}