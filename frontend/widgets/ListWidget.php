<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12
 * Time: 16:57
 */

namespace frontend\widgets;


use backend\models\Goods;
use yii\base\Widget;
use yii\helpers\Html;

class ListWidget extends Widget
{
    public function run(){
        $goods = Goods::find()->where(['is_on_sale'=>1])->all();
        $html = '';

        $html.='<div class="goodslist mt10">';
        foreach($goods as $good){
            $html.='<ul>';
            $html.='<li>';
            $html.='<dl>';
            $html.='<dt>'.Html::a(Html::img($good->logo)).'</dt>';
            $html.='<dd>'.Html::a($good->name).'</dd>';
            $html.='<dd>'.'<strong>'.$good->shop_price.'</strong>'.'</dd>';
            $html.='<dt>'.Html::a('<em>已有5人评价</em>').'</dt>';
            $html.='</dl>';
            $html.='</li>';
            $html.='<ul>';
        }
        $html.='</div>';
        return $html;
    }
}