<h1>商品相册</h1>
<?=\yii\bootstrap\Html::a('返回',['goods/index'],['class'=>'btn btn-primary'])?>
<?php foreach($models as $model):?>
 <div style="float: left">
<?=\yii\bootstrap\Html::img('@web/'.$model->path,['width'=>'200px','height'=>'200px'])?>
<?=\yii\bootstrap\Html::a('删除',['goods/photodel','id'=>$model->id,'ids'=>'goods_id'])?>
 </div>
<?php endforeach;?>
