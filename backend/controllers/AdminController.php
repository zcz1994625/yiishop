<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/2
 * Time: 11:19
 */

namespace backend\controllers;


use backend\models\Admin;
use backend\models\LoginForm;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Request;

class AdminController extends Controller
{

    //注册
    public function actionAdd(){
        $model = new Admin();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->password = \yii::$app->security->generatePasswordHash($model->password);
                $model->add_time =time();
                $model->last_login_ip = $_SERVER['REMOTE_ADDR'];
                $model->last_login_time = time();
                $model->save(false);
                //实例化rbac
                $authManager = \yii::$app->authManager;

                foreach($model->roles as $role){
                    $authManager->assign($authManager->getRole($role),$model->id);
                }
                \yii::$app->session->setFlash('success','注册成功');
                //注册后自动登录
                \yii::$app->user->login($model);
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    //管理员列表
    public function actionIndex(){
        $query = Admin::find();
        $pageSize = 5;
        $count = $query->count();
        $pager = new Pagination([
            'totalCount'=>$count,
            'pageSize'=>$pageSize
        ]);

        //定义参数
        $admins = $query->limit($pager->limit)->offset($pager->offset)->all();
//        var_dump($query);exit;
        return $this->render('index',['pager'=>$pager,'admins'=>$admins]);
    }

    //登录
    public function actionLogin(){
        $model = new LoginForm();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->login()){
                \yii::$app->session->setFlash('success','登录成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    //注销
    public function actionLogout(){
        \yii::$app->user->logout();
        \yii::$app->session->setFlash('success','注销成功');
        return $this->redirect(['admin/login']);
    }
    //删除管理员
    public function actionDel($id){
        $admin = Admin::findOne(['id'=>$id]);
        return $this->redirect(['admin/index']);
    }
    // 修改管理员信息
    public function actionEdit($id){
        $model = Admin::findOne(['id'=>$id]);
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->password = \yii::$app->security->generatePasswordHash($model->password);
                //$model->add_time =time();
                //$model->last_login_ip = $_SERVER['REMOTE_ADDR'];
                //$model->last_login_time = time();
                $model->save(false);
                //清除所有的角色
                $authManager = \yii::$app->authManager;
                $authManager->revokeAll($id);
                //循环再赋值
                foreach($model->roles as $role){
                    $authManager->assign($authManager->getRole($role),$model->id);
                }
                \yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionGuest()
    {
        //可以通过 Yii::$app->user 获得一个 User实例，
        $user = \Yii::$app->user;

        // 当前用户的身份实例。未认证用户则为 Null 。
        $identity = \Yii::$app->user->identity;
        var_dump($identity);
        // 当前用户的ID。 未认证用户则为 Null 。
        $id = \Yii::$app->user->id;
        var_dump($id);
        // 判断当前用户是否是游客（未认证的）
        $isGuest = \Yii::$app->user->isGuest;
        var_dump($isGuest);
    }

    //权限
    public function behaviors(){
        return[
          'ACF'=>[
              'class'=>AccessControl::className(),
              'only'=>['login','del','edit','index','logout','add'],
              'rules'=>[
                  [
                      'allow'=>true,
                      'actions'=>['logout','index'],
                      'roles'=>['@']
                  ],
                  [
                      'allow'=>true,
                      'actions'=>['login','add','index'],
                      'roles'=>['?']
                  ],
                  [
                      'allow'=>true,
                      'actions'=>['del','edit','add'],
                      'matchCallback'=>function(){
                          return (!\yii::$app->user->isGuest && \yii::$app->user->identity->username=='张昌再');
                          //return false;
                      }
                  ]
              ]
          ]
        ];
    }

}