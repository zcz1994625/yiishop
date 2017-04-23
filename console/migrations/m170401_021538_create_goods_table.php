<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m170401_021538_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->comment('商品名称'),
            'sn' => $this->integer()->notNull()->comment('编号'),
            'logo' => $this->string()->notNull()->comment('LOGO'),
            'goods_category_id' => $this->smallInteger()->defaultValue(0)->notNull()->comment('商品分类'),
            'brand_id' => $this->smallInteger()->notNull()->defaultValue(0)->comment('品牌'),
            'market_price' => $this->decimal(9,2)->notNull()->defaultValue(0.00)->comment('市场价格'),
            'shop_price' => $this->decimal(9,2)->notNull()->defaultValue(0.00)->comment('本店价格'),
            'stock' => $this->integer()->defaultValue(0)->notNull()->comment('库存'),
            'is_on_sale' => $this->smallInteger()->defaultValue(1)->notNull()->comment('是否上架'),
            'status' => $this->smallInteger()->defaultValue(1)->notNull()->comment('状态'),
            'sort' => $this->integer()->defaultValue(20)->notNull()->comment('排序'),
            'inputtime' => $this->integer()->defaultValue(0)->notNull()->comment('录入时间')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
