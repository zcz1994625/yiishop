<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/9
 * Time: 15:07
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password_hash;
    public $captcha;
    public $remember;

    public function rules(){
        return[
            [['username','password_hash','captcha'],'required'],
            ['remember','boolean']

        ];
    }

    public function attributeLabels(){
        return[
            'username'=>'用户名:',
            'password_hash'=>'密码:',
            'captcha'=>'验证码'
        ];
    }
    //登录验证
    public function Login(){
        if($this->validate()){
            //根据用户名查找
            $member = Member::findOne(['username'=>$this->username]);
            if($member){
               // var_dump($member);exit;
                if(\yii::$app->security->validatePassword($this->password_hash,$member->password_hash)){
                    //保存用户信息到session并登录
                    \yii::$app->user->login($member,$this->remember?3600*24*7:0);
                    //保存最后登录ip
                    $member = Member::findOne(['username'=>$this->username]);
                    $member->last_login_ip = ip2long($_SERVER['REMOTE_ADDR']);
                    $member->save(false);
                    return true;
                }else{
                    $this->addError('password_hash','密码不正确');
                }
            }else{
                $this->addError('username','用户名不存在');
            }
        }
        return false;
    }
}