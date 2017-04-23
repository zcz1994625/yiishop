<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $status
 */
class Brand extends \yii\db\ActiveRecord
{
    //public $logo_file;
    public static $statusOptions=['-1'=>'删除',0=>'隐藏',1=>'正常'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','logo'], 'required'],
            [['intro'], 'string'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
//            [['logo'], 'string', 'max' => 255]
           // ['logo_file','file','extensions'=>['png','gif','jpg'],'skipOnEmpty'=>false]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '品牌名称',
            'intro' => '描述',
//            'logo' => 'LOGO',
            'sort' => '排序',
            'status' => '状态',
        ];
    }
    /*
     * 处理图片地址
     * 如果是本地图片,添加@web别名
     * 如果是远程图片,不做处理
     */
    public function logoUrl()
    {
        if(strpos($this->logo,'http://')===false){
            return '@web'.$this->logo;
        }
        return $this->logo;
    }
}
