<?php

namespace backend\controllers;


use backend\models\Menu;
use yii\web\Controller;

class MenuController extends Controller
{
    //列表
    public function actionIndex(){
        $menus = Menu::find()->all();
        return $this->render('index',['menus'=>$menus]);
    }
    //添加
    public function actionAdd(){
        $model = new Menu();
        if($model->load(\yii::$app->request->post()) && $model->validate()){
            $model->save();
            \yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['menu/index']);
        }

        return $this->render('add',['model'=>$model]);
    }
    //删除
    public function actionDel($id){
        $menu = Menu::deleteAll(['id'=>$id]);
        \yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['menu/index']);
    }
    //编辑
    public function actionEdit($id){
        $model = Menu::findOne(['id'=>$id]);
        if($model->load(\yii::$app->request->post()) && $model->validate()){
            $model->save();
            \yii::$app->session->setFlash('success','修改成功');
            return $this->redirect(['menu/index']);
        }

        return $this->render('add',['model'=>$model]);
    }
}