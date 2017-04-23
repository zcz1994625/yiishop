<?php
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('添加',['goods-category/add'],['class'=>'btn btn-info']);
?>
<h1>goods-category/index</h1>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>操作</th>
    </tr>
    <tbody>
    <?php foreach($models as $model):?>
        <tr data-lft="<?=$model->lft?>" data-rgt="<?=$model->rgt?>" data-tree="<?=$model->tree?>">
            <td><?=$model->id?></td>
            <td><?=str_repeat('－－',$model->depth).$model->name?><span class="glyphicon glyphicon-chevron-up expand" style="float: right"></span></td>
            <td>
                <?=\yii\bootstrap\Html::a('删除',['goods-category/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
                <?=\yii\bootstrap\Html::a('编辑',['goods-category/edit','id'=>$model->id],['class'=>'btn btn-warning'])?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php
$js=<<<EOT
     $(".expand").click(function(){
        //如果有就替换
         $(this).toggleClass("glyphicon-chevron-down");
         $(this).toggleClass("glyphicon-chevron-up");

        //获取当前tr的左右值，tree值
        var tr = $(this).closest("tr");
        var p_lft = tr.attr("data-lft");
        var p_rgt = tr.attr("data-rgt");
        var p_tree= tr.attr("data-tree");
        $("tbody tr").each(function(){
            var lft = $(this).attr("data-lft");
            var rgt = $(this).attr("data-rgt");
            var tree = $(this).attr("data-tree");
            if(tree == p_tree &&　lft>p_lft && rgt<p_rgt){
                $(this).fadeToggle();
            }
        });
    });
EOT;

$this->registerJs($js);
?>
