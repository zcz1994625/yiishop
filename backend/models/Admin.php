<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $token
 * @property integer $token_create_time
 * @property integer $add_time
 * @property integer $last_login_time
 * @property string $last_login_ip
 */
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
//    public $img_file;
    public $captcha;
    public $roles;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //, 'salt' , 'token' , 'add_time', 'last_login_time'
            [['username', 'password', 'email'], 'required'],
            [['token_create_time', 'add_time', 'last_login_time'], 'integer'],
            [['username', 'password',  'email', 'token', 'last_login_ip'], 'string', 'max' => 255],
            [['email'],'email'],
            [['email','username'],'unique'],
            [['roles'],'safe']

            //'salt',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '姓名',
            'password' => '密码',
            'salt' => '盐',
            'email' => '邮箱',
            'token' => '自动登录令牌',
            'token_create_time' => '令牌创建时间',
            'add_time' => '注册时间',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录ip',
            'captcha'=>'验证码'
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.

    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public static function getRoleOptions(){
        $roles = \yii::$app->authManager->getRoles();
        return ArrayHelper::map($roles,'name','description');
    }

    //获取菜单
    public function getMenuItems(){
        //初始化菜单
        $menuItems = [];
        $menus = Menu::find()->where(['parent_id'=>0])->all();
        //遍历菜单
        foreach($menus as $menu){
            //获取子菜单
//            $children = Menu::find()->where(['parent_id'=>$menu->id]);
            //遍历子菜单
            $items = [];
            foreach($menu->menus as $child){
                //判断用户是否有该权限
                if(\yii::$app->user->can($child->url)){
                    $items[] = ['label'=>$child->name,'url'=>[$child->url]];
                }
            }
            //如果没有权限就不拼接菜单栏
            if(!empty($items)){
                $menuItems[] = [
                    'label'=>$menu->name,
                    'items'=>$items
                ];
            }

        }
        return  $menuItems;
    }

}
