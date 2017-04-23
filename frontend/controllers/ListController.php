<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12
 * Time: 10:10
 */

namespace frontend\controllers;



use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsGallery;

class ListController extends \yii\web\Controller
{
    public $layout = 'list';

    public function actionList($id)
    {
        $goods = Goods::find()->where(['goods_category_id'=>$id])->all();
        $category = GoodsCategory::findOne(['id'=>$id]);
        $brands = Brand::find()->all();
        return $this->render('list',['goods'=>$goods,'category'=>$category,'brands'=>$brands]);
    }

    public function actionGoods($goods_id,$category_id)
    {
        $goods = Goods::findOne(['id'=>$goods_id]);
        $category = GoodsCategory::findOne(['id'=>$category_id]);
        $gallerys = GoodsGallery::find()->where(['goods_id'=>$goods_id])->all();
        return $this->render('goods',['goods'=>$goods,'category'=>$category,'gallerys'=>$gallerys]);
    }


}