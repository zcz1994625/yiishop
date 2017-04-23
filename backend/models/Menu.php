<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $url
 * @property string $description
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'required'],
            [['name', 'url', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => '上级分类',
            'name' => '名称',
            'url' => '路由',
            'description' => '描述',
        ];
    }
    //获取分类数据
    public static function getMenuOptions(){
        $menus = Menu::find()->all();
        $models[] =['id'=>0,'name'=>'顶级分类','parent_id'=>0];
        $models = ArrayHelper::merge($models,$menus);
        return ArrayHelper::map($models,'id','name');
    }

    public function getMenus(){
        return $this->hasMany($this,['parent_id'=>'id']);
    }
}
