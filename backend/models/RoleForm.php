<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/5
 * Time: 15:58
 */

namespace backend\models;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model
{
    public $name;//角色名
    public $description;//描述
    public $permissions=[];//角色权限
    const SCENARIO_ADD = 'add';


    //指定场景参数
    public function scenario(){
        $scenarios = parent::scenarios();
        return ArrayHelper::merge($scenarios,[
            self::SCENARIO_ADD=>[['name','description','permissions']],
        ]);
    }

    public function rules(){
        return[
            [['name','description'],'required'],
            [['name','description'],'string','max'=>50],
            [['name'],'validateName','on'=>self::SCENARIO_ADD],
            [['permissions'],'safe']
        ];
    }

    public function attributeLabels(){
        return[
            'name'=>'角色名称',
            'description'=>'描述',
            'permissions'=>'权限'
        ];
    }
    /**
     * 自定义验证规则
     */
    public function validateName($attribute,$params){
        if(\yii::$app->authManager->getPermission($this->$attribute)){
            $this->addError($attribute,'角色已存在');
        }
    }
    /**
     * 获取所有权限
     */
    public static function getPermissionOptions(){
        $permissions = \yii::$app->authManager->getPermissions();
        return ArrayHelper::map($permissions,'name','description');
    }
}