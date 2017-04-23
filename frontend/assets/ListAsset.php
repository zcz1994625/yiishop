<?php

namespace frontend\assets;


use yii\web\AssetBundle;

class ListAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/list.css',
        'style/common.css',
        'style/bottomnav.css',
        'style/goods.css',
        'style/footer.css',
        'style/jqzoom.css',
    ];
    public $js = [
        'js/header.js',
        'js/list.js',
        'js/goods.js',
        'js/jqzoom-core.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}