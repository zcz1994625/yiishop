<?php


namespace backend\models;


use yii\base\Model;

class PermissionForm extends Model
{
    public $name;//权限名（路由）
    public $description;//描述

    public function rules(){
        return[
            [['name','description'],'required'],
            [['name','description'],'string','max'=>50],
            [['name'],'validateName']
        ];
    }

    public function attributeLabels(){
        return[
            'name'=>'名称（路由）',
            'description'=>'描述'
        ];
    }
    /**
     * 自定义验证规则
     */
    public function validateName($attribute,$params){
       if(\yii::$app->authManager->getPermission($this->$attribute)){
           $this->addError($attribute,'权限已存在');
       }
    }
}