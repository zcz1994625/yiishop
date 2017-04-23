<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "locate".
 *
 * @property integer $id
 * @property string $name
 * @property string $provence
 * @property string $city
 * @property string $area
 * @property string $locate
 * @property string $tel
 * @property integer $status
 */
class Locate extends \yii\db\ActiveRecord
{
    public static $statusOptions = [0=>false,1=>true];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'locate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'provence', 'city', 'area', 'locate', 'tel'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['provence', 'city', 'area', 'locate'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '收货人：',
            'provence' => '省份',
            'city' => '城市',
            'area' => '地区',
            'locate' => '详细地址：',
            'tel' => '手机号：',
            'status' => '设为默认地址',
        ];
    }
}
