<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/2
 * Time: 14:30
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $captcha;

    public function rules(){
        return[
            [['username','password'],'required']
        ];
    }

    public function attributeLabels(){
        return[
          'username'=>'用户名',
            'password'=>'密码',
            'captcha'=>'验证码'
        ];
    }

    public function Login(){
        //验证
        if($this->validate()){
            //柑橘用户名查找用户
            $admin = Admin::findOne(['username'=>$this->username]);
            //验证用户名
            if($admin){
                //对比密码
                if(\yii::$app->security->validatePassword($this->password,$admin->password)){
                    //保存用户信息到session
                    \yii::$app->user->login($admin);
                    return true;
                }else{
                    //密码错误
                    $this->addError('password','密码错误');
                }
            }else{
                //用户名不存在
                $this->addError('username','用户名不存在');
            }
        }
        return false;
    }
}