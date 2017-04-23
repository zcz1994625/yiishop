<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/30
 * Time: 15:09
 */

namespace backend\components;


use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;

class GoodsCategoryQuery extends ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}