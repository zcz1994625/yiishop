<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $is_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{
    public static $is_on_saleOptions=[1=>'是',0=>'否'];
    public static $statusOptions = [1=>'正常',0=>'回收站'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','logo'], 'required'],
            [['sn', 'goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'inputtime'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '编号',
            'logo' => 'LOGO',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌',
            'market_price' => '市场价格',
            'shop_price' => '本店价格',
            'stock' => '库存',
            'is_on_sale' => '是否上架',
            'status' => '状态',
            'sort' => '排序',
            'inputtime' => '录入时间',
        ];
    }

    public function getBrands(){
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }

    public static function getBrandOptions(){
        $brandOptions = Brand::find()->all();
        return ArrayHelper::map($brandOptions,'id','name');
     }

    public function getGoodsCategory(){
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }

    public static function getCategoryOptions(){
        $categoryOptions= GoodsCategory::find()->all();
        return ArrayHelper::map($categoryOptions,'id','name');
    }

    public function getGoodsIntro(){
        return $this->hasOne(GoodsIntro::className(),['id'=>'goods_id']);
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
