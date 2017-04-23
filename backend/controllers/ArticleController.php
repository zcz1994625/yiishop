<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/29
 * Time: 16:27
 */

namespace backend\controllers;


use backend\filters\AccessFilter;
use backend\models\Article;
use backend\models\ArticleDetaila;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class ArticleController extends Controller
{
    public function behaviors(){
        return[
            'accessFilter'=>[
                'class'=>AccessFilter::className(),
            ],
        ];
    }
    //列表
    public function actionIndex(){
        //获取总条数
        $query = Article::find();
        $count = $query->count();
        //每页显示条数
        $pageSize = 3;
        //实例化分页类
        $pager = new Pagination([
            'totalCount'=>$count,
            'pageSize'=>$pageSize
        ]);
        //定义参数
        $articles = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['articles'=>$articles,'pager'=>$pager]);
    }
    //添加
    public function actionAdd(){
        //s实例化模型
        $model = new Article();
        $model_detail = new ArticleDetaila();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            $model_detail->load($request->post());
            if($model && $model_detail){
                if($model->validate() && $model_detail->validate()){
                    $model->input_time=time();
                    $model->save();
                    $model->id = $model_detail->article_id;

                    $model_detail->save();
                    \yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect(['article/index']);
                }
            }
        }
        return $this->render('add',['model'=>$model,'model_detail'=>$model_detail]);
    }
    //删除
    public function actionDel($id){
        $article = Article::deleteAll(['id'=>$id]);
        $article_content = ArticleDetaila::deleteAll(['article_id'=>$id]);
        return $this->redirect(['article/index']);
    }
    //编辑
    public function actionEdit($id){
        $model = Article::findOne(['id'=>$id]);
        $model_detail = ArticleDetaila::findOne(['article_id'=>$id]);
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            $model_detail->load($request->post());
            if($model && $model_detail){
                if($model->validate() && $model_detail->validate()){
                    $model->input_time=time();
                    $model->save();
                    $model->id = $model_detail->article_id;

                    $model_detail->save();
                    \yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect(['article/index']);

                }
            }
        }
        return $this->render('add',['model'=>$model,'model_detail'=>$model_detail]);
    }
}