<?php
echo \yii\bootstrap\Html::a('返回',['brand/list'],['class'=>'btn btn-info']);
?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>品牌名称</th>
        <th>LOGO</th>
        <th>状态</th>
        <th>排序</th>
        <th>操作</th>
    </tr>
    <?php foreach($brands as $brand):?>
        <tr>
            <td><?=$brand->id?></td>
            <td><?=$brand->name?></td>
            <td><?=\yii\bootstrap\Html::img('@web'.$brand->logo,['width'=>'30px'])?></td>
            <td><?=\backend\models\Brand::$statusOptions[$brand->status]?></td>
            <td><?=$brand->sort?></td>
            <td>
                <?=\yii\bootstrap\Html::a('删除',['brand/remove','id'=>$brand->id],['class'=>'btn btn-danger'])?>
                <?=\yii\bootstrap\Html::a('恢复',['brand/back','id'=>$brand->id],['class'=>'btn btn-success'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>

<?php
echo \yii\widgets\LinkPager::widget([
   'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'
]);
