<h1>文章管理</h1>
<?php
echo \yii\bootstrap\Html::a('添加',['article/add'],['class'=>'btn btn-info'])
?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>文章名称</th>
        <th>文章类型</th>
        <th>是否上线</th>
        <th>排序</th>
        <th>加入时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($articles as $article):?>
        <tr>
            <td><?=$article->id?></td>
            <td><?=$article->name?></td>
            <td><?=$article->categories->name?></td>
            <td><?=\backend\models\Article::$statusOptions[$article->status]?></td>
            <td><?=$article->sort?></td>
            <td><?=date('Y-m-d H:i:s',$article->input_time)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('删除',['article/del','id'=>$article->id],['class'=>'btn btn-danger'])?>
                <?=\yii\bootstrap\Html::a('编辑',['article/edit','id'=>$article->id],['class'=>'btn btn-success'])?>
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
?>
