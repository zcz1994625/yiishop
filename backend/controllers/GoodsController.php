<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/1
 * Time: 10:37
 */

namespace backend\controllers;


use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsController extends Controller
{   //列表
    public function actionIndex(){
        $query = Goods::find()->where(['=','status','1']);
        //定义显示条数
        $pageSize = 4;
        //总条数
        $count = $query->count();
        //实例化分页类
        $pager = new Pagination([
            'totalCount'=> $count,
            'pageSize'=>$pageSize
        ]);
        //定义参数
        $goods = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['pager'=>$pager,'goods'=>$goods]);
    }
    //添加商品
    public function actionAdd(){
        $model = new Goods();
        $model_intro = new GoodsIntro();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            $model_intro->load($request->post());
            $cate = GoodsCategory::findOne(['id'=>$model->goods_category_id]);
//            var_dump($model->goods_category_id);exit;
            if($cate->depth < 1){
                \yii::$app->session->setFlash('danger','请选择2级分类');
                return $this->refresh();
            }

            if($model->validate() && $model_intro->validate()){
                //实例化count模型
                $day_count = new GoodsDayCount();
                $day = date('Ymd');
                $count = GoodsDayCount::findOne(['day'=>$day]);
                if($count != null){
                    //数量自增1
                    $count->count +=1;
                    $count->save();
                }else{
                    //新增数据
                    $day_count->day = $day;
                    $day_count->count = 1;
                    $day_count->save();
                }

                $num = strlen(GoodsDayCount::findOne(['day'=>$day])->count);
                $model->sn = $day.str_repeat(0,7-$num).GoodsDayCount::findOne(['day'=>$day])->count;
//                var_dump($model->sn);exit;
                $model->inputtime = time();
                $model->save();
                $model_intro->goods_id=$model->id;
                $model_intro->save();
                \yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods/addp','id'=>$model->id]);
            }
        }
        $models = GoodsCategory::find()->asArray()->all();
        $models[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $models = Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models,'model_intro'=>$model_intro]);
    }
    //编辑
    public function actionEdit($id){
        $model = Goods::findOne(['id'=>$id]);
        $model_intro = GoodsIntro::findOne(['goods_id'=>$id]);
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            $model_intro->load($request->post());
            $cate = GoodsCategory::findOne(['id'=>$model->goods_category_id]);
//            var_dump($model->goods_category_id);exit;
            if($cate->depth < 1){
                \yii::$app->session->setFlash('danger','请选择2级分类');
                return $this->refresh();
            }

            if($model->validate() && $model_intro->validate()){
                //实例化count模型
//                $day_count = new GoodsDayCount();
//                $day = date('Ymd');
//                $count = GoodsDayCount::findOne(['day'=>$day]);
//                if($count != null){
//                    //数量自增1
//                    $count->count +=1;
//                    $count->save();
//                }else{
//                    //新增数据
//                    $day_count->day = $day;
//                    $day_count->count = 1;
//                    $day_count->save();
//                }
//
//                $num = strlen(GoodsDayCount::findOne(['day'=>$day])->count);
//                $model->sn = $day.str_repeat(0,7-$num).GoodsDayCount::findOne(['day'=>$day])->count;
//                var_dump($model->sn);exit;
//                $model->inputtime = time();
                $model->save();
                $model->id = $model_intro->goods_id;
                $model_intro->save();
                \yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['goods/index']);
            }
        }
        $models = GoodsCategory::find()->asArray()->all();
        $models[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $models = Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models,'model_intro'=>$model_intro]);
    }
    //删除到回收站
    public function actionDel($id){
        $good = Goods::findOne(['id'=>$id]);
        $good->status = 0;
        $good->save();
        \yii::$app->session->setFlash('success','OK');
        return $this->redirect(['goods/index']);
    }

    //回收站
    public function actionDellist(){
        $query = Goods::find()->where(['status'=>0]);
        //定义显示条数
        $pageSize = 4;
        //总条数
        $count = $query->count();
        //实例化分页类
        $pager = new Pagination([
            'totalCount'=> $count,
            'pageSize'=>$pageSize
        ]);
        //定义参数
        $goods = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('dellist',['pager'=>$pager,'goods'=>$goods]);
    }
    //彻底删除
    public function actionRemove($id){
        $brand = Goods::deleteAll(['id'=>$id]);

        \yii::$app->session->setFlash('success','彻底删除');
        return $this->redirect(['goods/dellist']);
    }
    //恢复
    public function actionBack($id){
        $good = Goods::findOne(['id'=>$id]);

        $good->status = 1;

        $good->save();

        return $this->redirect(['goods/dellist']);
    }

    //相册添加
    public function actionAddp($id){
        $model = new GoodsGallery();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            //实例化上传文件对象
            $model->img_file = UploadedFile::getInstances($model,'img_file');
            if($model->validate()){
                if($model->img_file){
                   //循环
                    foreach($model->img_file as $img_file){
                        //路径
                        $fileName = 'upload/goods_gallery'.uniqid().'.'.$img_file->extension;
                        if($img_file->saveAs($fileName,false)){
                            $img = new GoodsGallery();
                            $img->path = $fileName;
                            $img->goods_id = $id;
                            $img->save(false);
                            \yii::$app->session->setFlash('success','上传成功');

                        }

                    }
                    return $this->redirect(['goods/photo']);
                }
            }
        }
        return $this->render('photo',['model'=>$model]);
    }

    //相册列表
    public function actionGallery($id){
        $models = GoodsGallery::find()->where(['goods_id'=>$id])->all();
//        var_dump($models);exit;
        return $this->render('gallery',['models'=>$models,'id'=>$id]);
    }
    //相册的删除
    public function actionPhotodel($id,$ids){
        $gallery = GoodsGallery::deleteAll(['id'=>$id]);
        return $this->redirect(['goods/gallery','id'=>$ids]);
    }



    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/brand',
                'baseUrl' => '@web/upload/brand',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
//                'format' => function (UploadAction $action) {
//                    $fileext = $action->uploadfile->getExtension();
//                    $filename = sha1_file($action->uploadfile->tempName);
//                    return "{$filename}.{$fileext}";
//                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    //$action->output['fileUrl'] = $action->getWebUrl();
//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                    //将图片上传到七牛云
                    $qiniu = \Yii::$app->qiniu;//实例化七牛云组件
                    $qiniu->uploadFile($action->getSavePath(),$action->getFilename());//将本地图片上传到七牛云
                    $url = $qiniu->getLink($action->getFilename());//获取图片在七牛云上的url地址
                    $action->output['fileUrl'] = $url;//将七牛云图片地址返回给前端js
                },
            ],
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/upload/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]
        ];
    }

}