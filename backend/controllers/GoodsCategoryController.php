<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/31
 * Time: 14:22
 */

namespace backend\controllers;


use backend\models\GoodsCategory;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Request;

class GoodsCategoryController extends Controller
{   //列表
    public function actionIndex(){
        $models = GoodsCategory::find()->orderBy(['tree'=>SORT_ASC,'lft'=>SORT_ASC])->all();
        return $this->render('index',['models'=>$models]);
    }

    //添加
    public function actionAdd(){
        $model = new GoodsCategory();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if($model->parent_id==0){
                    //创建一级分类
                    $model->makeRoot();
                }else{
                    //创建下级分类
                    //查找父分类
                    $model_parent = GoodsCategory::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($model_parent);
                }
                \yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods-category/index']);
            }
        }
        $models = GoodsCategory::find()->asArray()->all();
        $models[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $models = Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }

    //修改
    public function actionEdit($id){
        $model = GoodsCategory::findOne(['id'=>$id]);
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                try{
                    if($model->parent_id==0){
                        //创建一级分类
                        $model->makeRoot();
                    }else{
                        //创建下级分类
                        //查找父分类
                        $model_parent = GoodsCategory::findOne(['id'=>$model->parent_id]);
                        $model->prependTo($model_parent);
                        \yii::$app->session->setFlash('success','修改成功');
                        return $this->redirect(['goods-category/index']);
                    }
                }catch (\yii\db\Exception $e){
                    $model->addError('parent_id',$e->getMessage());
                }
            }

        }
        $models = GoodsCategory::find()->asArray()->all();
        $models[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $models = Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }
    //删除
    public function actionDel($id){

    }
}