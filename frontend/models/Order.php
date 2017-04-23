<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province_name
 * @property string $city_name
 * @property string $area_name
 * @property string $detail_address
 * @property string $tel
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property integer $pay_type_id
 * @property string $pay_type_name
 * @property string $price
 * @property integer $status
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'name', 'province_name', 'city_name', 'area_name', 'detail_address', 'tel', 'delivery_id', 'delivery_name', 'delivery_price', 'pay_type_name', 'create_time'], 'required'],
            [['member_id', 'delivery_id', 'pay_type_id', 'status', 'create_time'], 'integer'],
            [['delivery_price', 'price'], 'number'],
            [['name', 'province_name', 'city_name', 'area_name'], 'string', 'max' => 20],
            [['detail_address'], 'string', 'max' => 40],
            [['tel'], 'string', 'max' => 11],
            [['delivery_name'], 'string', 'max' => 30],
            [['pay_type_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '会员id',
            'name' => '收货人',
            'province_name' => '省份',
            'city_name' => '城市',
            'area_name' => '地区',
            'detail_address' => '详细地址',
            'tel' => '电话',
            'delivery_id' => '配送方式ID',
            'delivery_name' => '配送方式',
            'delivery_price' => '运费',
            'pay_type_id' => '支付方式ID',
            'pay_type_name' => '支付方式',
            'price' => '价格',
            'status' => '状态',
            'create_time' => '订单时间',
        ];
    }
}
