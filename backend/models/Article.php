<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property integer $article_category_id
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $input_time
 */
class Article extends \yii\db\ActiveRecord
{
    public static $statusOptions=[1=>'是',0=>'否'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','status'], 'required'],
            [['article_category_id', 'status', 'sort', 'input_time'], 'integer'],
            [['intro'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名称',
            'article_category_id' => '文章分类',
            'intro' => '描述',
            'status' => '是否上线',
            'sort' => '排序',
            'input_time' => '加入时间',
        ];
    }

    public function getCategories(){
        return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }

    public function getDetail(){
        return $this->hasOne(ArticleDetaila::className(),['id'=>'article_id']);
    }

    public static function getCategoryOptions(){
        $categoryOptions = ArticleCategory::find()->all();
        return ArrayHelper::map($categoryOptions,'id','name');
    }
}
