<?php

namespace backend\filters;
use yii\base\ActionFilter;
use yii\web\HttpException;

class AccessFilter extends ActionFilter
{
    public function beforeAction($action){
        //判断当前用户是否拥有当前权限
        //当前操作 ===$action->uniqueID
       if(!\yii::$app->user->can($action->uniqueId)){
           //判断用户是否登录
           if(\yii::$app->user->isGuest){
                //获取操作所属的控制器
               return $action->controller->redirect(\yii::$app->user->loginUrl);
           }


            //抛出403没有权限的状态码
            throw new HttpException(403,'您没有该操作权限!');

            //进制操作继续执行
           return false;
       }
        return parent::beforeAction($action);
    }
}