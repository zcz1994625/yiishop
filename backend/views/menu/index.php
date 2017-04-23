
<h1>菜单管理</h1>
<?php


?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>上级分类</th>
        <th>名称</th>
        <th>路由</th>
        <th>操作</th>
    </tr>
    <?php foreach($menus as $menu):?>
        <tr>
            <td><?=$menu->id?></td>
            <td><?=$menu->parent_id?></td>
            <td><?=$menu->name?></td>
            <td><?=$menu->url?></td>
            <td>
                <?=\yii\bootstrap\Html::a('删除',['menu/del','id'=>$menu->id],['class'=>'btn btn-danger'])?>
                <?=\yii\bootstrap\Html::a('编辑',['menu/edit','id'=>$menu->id],['class'=>'btn btn-warning'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
