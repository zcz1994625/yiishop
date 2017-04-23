<?php
echo \yii\bootstrap\Html::a('返回',['goods/index'],['class'=>'btn btn-info']);
?>

    <table class="table table-hover table-bordered">
        <tr>
            <th>ID</th>
            <th>商品名称</th>
            <th>编号</th>
            <th>LOGO</th>
            <th>所属分类</th>
            <th>所属品牌</th>
            <th>市场价格</th>
            <th>本店价格</th>
            <th>库存</th>
            <th>是否上架</th>
            <th>状态</th>
            <th>排序</th>
            <th>录入时间</th>
            <th>操作</th>
        </tr>
        <?php foreach($goods as $good):?>
            <tr>
                <td><?=$good->id?></td>
                <td><?=$good->name?></td>
                <td><?=$good->sn?></td>
                <td><?=\yii\bootstrap\Html::img($good->logoUrl(),['width'=>'30px'])?></td>
                <td><?=$good->goodsCategory->name?></td>
                <td><?=$good->brands->name?></td>
                <td><?=$good->market_price?></td>
                <td><?=$good->shop_price?></td>
                <td><?=$good->stock?></td>
                <td><?=\backend\models\Goods::$is_on_saleOptions[$good->is_on_sale]?></td>
                <td><?=\backend\models\Goods::$statusOptions[$good->status]?></td>
                <td><?=$good->sort?></td>
                <td><?=date('Y-m-d H:i:s',$good->inputtime)?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('删除',['goods/remove','id'=>$good->id],['class'=>'btn btn-danger'])?>
                    <?=\yii\bootstrap\Html::a('恢复',['goods/back','id'=>$good->id],['class'=>'btn btn-info'])?>
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
