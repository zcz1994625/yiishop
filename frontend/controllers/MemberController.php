<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/9
 * Time: 11:37
 */

namespace frontend\controllers;


use frontend\models\LoginForm;
use frontend\models\Member;
use yii\web\Controller;



use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;

class MemberController extends Controller
{   public $layout = 'login';//指定布局文件
    //public $enableCsrfValidation = false;
    /**
     * 用户注册
     */
    public function actionRegister(){
        $model = new Member();
        if($model->load(\yii::$app->request->post()) && $model->validate()){
            $model->password_hash = \yii::$app->security->generatePasswordHash( $model->password_hash);
            $model->last_login_ip = ip2long($_SERVER['REMOTE_ADDR']);
            //设置auth_key
            $model->auth_key = \yii::$app->security->generateRandomString();
            $model->save(false);
            \yii::$app->user->login($model);//注册之后自动登录
            \yii::$app->session->setFlash('success','注册成功');
            return $this->redirect(['member/index']);
        }

        return $this->render('register',['model'=>$model]);
    }
    /**
     * 获取短信验证码
     */
    public function actionCode(){
       $tel = \yii::$app->request->post('tel');
       $code = rand(1000,9999);
       //保存到session
//        \yii::$app->session->set('tel_'.$tel,$code);
    }
    /**
     * 登录
     */
    public function actionLogin(){
        $model = new LoginForm();
        if($model->load(\yii::$app->request->post())){
            if($model->login()){
                \yii::$app->session->setFlash('success','登录成功');
                return $this->refresh();
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    /**
     * 注销
     */
    public function actionLogout(){
        \yii::$app->user->logout();
        \yii::$app->session->setFlash('success','注销成功');
        return $this->redirect(['member/login']);
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

    public function actionTest(){


// 配置信息
        $config = [
            'app_key'    => '23746571',
            'app_secret' => 'a62bc7284d945dbcac77e8e67b95cc87',
            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];


// 使用方法一
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum('13890021537')
            ->setSmsParam([
                'content' => rand(100000, 999999),
                'name' => '爸爸'
            ])
            ->setSmsFreeSignName('张昌再')
            ->setSmsTemplateCode('SMS_60725118');

        $resp = $client->execute($req);
        var_dump($resp);
    }
}