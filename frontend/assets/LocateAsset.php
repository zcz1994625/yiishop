<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 15:49
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class LocateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/login.css',
        'style/footer.css',
        'style/home.css',
        'style/address.css',
        'style/bottomnav.css'


    ];
    public $js = [
        'js/header.js',
        'js/home.js'

    ];
    public $depends = [
        //JqueryAsset::className(),
        'yii\web\JqueryAsset',
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}