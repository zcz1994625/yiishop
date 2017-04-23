<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 22:27
 */

namespace frontend\controllers;


use backend\models\Goods;
use yii\web\Controller;

class IndexController extends Controller
{   public $layout = 'index';

    /**
     * 首页
     */
    public function actionIndex(){
        $goods = Goods::find()->all();

        return $this->render('index',['goods'=>$goods]);
    }


    public function actionList()
    {
        return $this->render('list');
    }

    public function actionCart(){
        $this->layout = 'cart';
        if(\yii::$app->user->isGuest){
            //用户未登录,将商品id和数量从cookie中取出
            $cookies = \yii::$app->request->cookies;
        }

    }
}