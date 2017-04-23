<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/28
 * Time: 13:33
 */

namespace backend\controllers;
use backend\filters\AccessFilter;
use xj\uploadify\UploadAction;



use backend\models\Brand;
use yii\base\ActionFilter;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;
use crazyfd\qiniu\Qiniu;

class BrandController extends Controller
{
    public function behaviors(){
        return[
          'accessFilter'=>[
              'class'=>AccessFilter::className(),
          ],
        ];
    }

    //列表
    public function actionList(){
        //实现一个query对象
        $query = Brand::find()->where(['>=','status','0']);
        //定义显示条数
        $pageSize = 3;
        //总条数
        $count = $query->count();
        //实例化分页类
        $pager = new Pagination([
           'totalCount'=> $count,
            'pageSize'=>$pageSize
        ]);
        //定义参数
        $brands = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('list',['pager'=>$pager,'brands'=>$brands]);
    }
    //添加
    public function actionAdd(){
        $model = new Brand();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            //实例化上传文件对象
            //$model->logo_file = UploadedFile::getInstance($model,'logo_file');
            if($model->validate()){
//                if($model->logo_file){
//                    //路径
//                    $fileName = 'upload/brand'.uniqid().'.'.$model->logo_file->extension;
//                    $model->logo_file->saveAs($fileName,false);
//                    $model->logo= $fileName;
//                }
                $model->save();
//                var_dump($model);exit;
                //跳转
                \yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['brand/list']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //编辑
    public function actionEdit($id){
        $model = Brand::findOne(['id'=>$id]);
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            //实例化上传文件对象
            //$model->logo_file = UploadedFile::getInstance($model,'logo_file');
            if($model->validate()){
//                if($model->logo_file){
//                    //路径
//                    $fileName = 'upload/brand'.uniqid().'.'.$model->logo_file->extension;
//                    $model->logo_file->saveAs($fileName,false);
//                    $model->logo= $fileName;
//                }
                $model->save();
//                var_dump($model);exit;
                //跳转
                \yii::$app->session->setFlash('success','编辑成功');
                return $this->redirect(['brand/list']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //逻辑删除，保存到回收站
    public function actionDel($id){
        //根据id获取数据
        $brand = Brand::findOne(['id'=>$id]);
        $brand->status = -1;
        $brand->save(false);
        \yii::$app->session->setFlash('success','删除到回收站');
        return $this->redirect(['brand/list']);
    }
    //回收站
    public function actionDellist(){
        //获取所有状态是-1的数据
        $query = Brand::find()->where(['status'=>-1]);
        $pageSize = 3;
        //总条数
        $count = $query->count();
        //实例化分页类
        $pager = new Pagination([
            'totalCount'=> $count,
            'pageSize'=>$pageSize
        ]);
        //定义参数
        $brands = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('dellist',['pager'=>$pager,'brands'=>$brands]);
    }
    //删除
    public function actionRemove($id){
        $brand = Brand::deleteAll(['id'=>$id]);

        \yii::$app->session->setFlash('success','彻底删除');
        return $this->redirect(['brand/dellist']);
    }
    //恢复
    public function actionBack($id){
        $brand = Brand::findOne(['id'=>$id]);

        $brand->status = 1;

        $brand->save(false);

        return $this->redirect(['brand/dellist']);
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
        ];
    }

//    public function actionTest(){
//        $ak = 'g5xH_-oTiXmRokc9ycpHD4Lp1mXBfXNsQL_l0QEg';
//        $sk = 'sUIyO5xu1iCNleaY-WmwQlqLCbPMpOtFz8e6uj2-';
//        $domain = 'http://onkwbr5il.bkt.clouddn.com/';
//        $bucket = 'yii2-php';
//
//        $qiniu = new Qiniu($ak, $sk,$domain, $bucket);
//        $key = time();
//        $qiniu->uploadFile($_FILES['tmp_name'],$key);
//        $url = $qiniu->getLink($key);
//    }
}