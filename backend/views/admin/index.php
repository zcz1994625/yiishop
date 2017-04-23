<?php
echo \yii\bootstrap\Html::a('注册',['admin/add'],['class'=>'btn btn-info']);
echo \yii\bootstrap\Html::a('注销',['admin/logout'],['class'=>'btn btn-warning']);
?>
<h1>管理员列表</h1>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>姓名</th>
        <th>Email</th>
        <th>注册时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($admins as $admin):?>
        <tr>
            <td><?=$admin->id?></td>
            <td><?=$admin->username?></td>
            <td><?=$admin->email?></td>
            <td><?=date('Y-m-d H:i:s',$admin->add_time)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('删除',['admin/del','id'=>$admin->id],['class'=>'btn btn-danger'])?>
                <?=\yii\bootstrap\Html::a('编辑',['admin/edit','id'=>$admin->id],['class'=>'btn btn-warning'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'
])
?>
