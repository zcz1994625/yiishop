<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 22:17
 */

namespace frontend\widgets;
use backend\models\Article;
use backend\models\ArticleCategory;
use yii\base\Widget;

class HelpWidget extends Widget
{
    public function run()
    {
        $categories = ArticleCategory::find()->where(['status'=>1])->all();
        $html = '';


        $html.='<div class="bottomnav w1210 bc mt10">';
        foreach($categories as $k=>$category){
            $html.='<div class="bnav".$k+1>
			<h3><b></b> <em>'.$category->name.'</em></h3>';
			$articles = Article::find()->where(['article_category_id'=>$category->id])->all();

			$html.='<ul>';
            foreach($articles as $article){
                $html.='<li><a href="#">'.$article->name.'</a></li>';
            }

			$html.='</ul>';
		$html.='</div>';
        }
        $html.='</div>';
        return $html;
    }
}