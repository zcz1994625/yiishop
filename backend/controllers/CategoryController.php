<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/29
 * Time: 11:58
 */

namespace backend\controllers;


use backend\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class CategoryController extends Controller
{   //列表
    public function actionIndex(){
        //获取总条数
        $query = ArticleCategory::find();
        $count = $query->count();
        //每页显示条数
        $pageSize = 3;
        //实例化分页类
        $pager = new Pagination([
            'totalCount'=>$count,
            'pageSize'=>$pageSize
        ]);
        //定义参数
        $categories = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['categories'=>$categories,'pager'=>$pager]);
    }
    //添加
    public function actionAdd(){
        //实例化模型
        $model = new ArticleCategory();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['category/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //删除
    public function actionDel($id){
        $category = ArticleCategory::deleteAll(['id'=>$id]);
        return $this->redirect(['category/index']);
    }
    //编辑
    public function actionEdit($id){
        $model = ArticleCategory::findOne(['id'=>$id]);
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['category/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
}