<h1 style="color: #666666" >文章分类列表</h1>
<?php

echo \yii\bootstrap\Html::a('添加',['category/add'],['class'=>'btn btn-info']);
?>

<table class="table table-hover table-bordered">
    <tr>
        <th>ID</th>
        <th>文章名称</th>
        <th>是否上线</th>
        <th>排序</th>
        <th>是否是帮助类文章</th>
        <th>操作</th>
    </tr>
    <?php foreach($categories as $category):?>
     <tr>
         <td><?=$category->id?></td>
         <td><?=$category->name?></td>
         <td><?=\backend\models\ArticleCategory::$statusOptions[$category->status]?></td>
         <td><?=$category->sort?></td>
         <td><?=\backend\models\ArticleCategory::$is_helpOptions[$category->is_help]?></td>
         <td>
             <?=\yii\bootstrap\Html::a('删除',['category/del','id'=>$category->id],['class'=>'btn btn-danger'])?>
             <?=\yii\bootstrap\Html::a('编辑',['category/edit','id'=>$category->id],['class'=>'btn btn-success'])?>
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
