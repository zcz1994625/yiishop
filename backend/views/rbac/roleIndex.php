<?php
echo \yii\bootstrap\Html::a('添加',['rbac/add-role'],['class'=>'btn btn-info']);
?>
<h1>角色列表</h1>
<table class="table table-hover table-bordered">
    <tr>
        <th>权限名称</th>
        <th>权限描述</th>
        <th>操作</th>
    </tr>
    <?php foreach($roles as $role):?>
        <tr>
            <td><?=$role->name?></td>
            <td><?=$role->description?></td>
            <td>
                <?=\yii\bootstrap\Html::a('删除',['rbac/role-del','name'=>$role->name],['class'=>'btn btn-danger'])?>
                <?=\yii\bootstrap\Html::a('编辑',['rbac/role-edit','name'=>$role->name],['class'=>'btn btn-warning'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
