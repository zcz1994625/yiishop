<?php
echo \yii\bootstrap\Html::a('添加',['brand/add'],['class'=>'btn btn-info']);
echo \yii\bootstrap\Html::a('回收站',['brand/dellist'],['class'=>'btn btn-warning'])
?>

<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>品牌名称</th>
        <th>LOGO</th>
        <th>排序</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach($brands as $brand):?>
        <tr>
            <td><?=$brand->id?></td>
            <td><?=$brand->name?></td>
            <td><?=\yii\bootstrap\Html::img($brand->logoUrl(),['width'=>'30px'])?></td>
            <td><?=$brand->sort?></td>
            <td><?=\backend\models\Brand::$statusOptions[$brand->status]?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['brand/edit','id'=>$brand->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['brand/del','id'=>$brand->id],['class'=>'btn btn-danger'])?>
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

