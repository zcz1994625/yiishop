<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m170415_021404_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id' => $this->integer()->notNull()->comment('会员id'),
            'name' => $this->string(20)->notNull()->comment('收货人'),
            'province_name' => $this->string(20)->notNull()->comment('省份'),
            'city_name' => $this->string(20)->notNull()->comment('城市'),
            'area_name' => $this->string(20)->notNull()->comment('地区'),
            'detail_address' => $this->string(40)->notNull()->comment('详细地址'),
            'tel' => $this->string(11)->notNull()->comment('电话'),
            'delivery_id' => $this->smallInteger(3)->notNull()->comment('配送方式ID'),
            'delivery_name' => $this->string(30)->notNull()->comment('配送方式'),
            'delivery_price' => $this->decimal(7,2)->notNull()->comment('运费'),
            'pay_type_id' => $this->integer()->defaultValue(1)->notNull()->comment('支付方式ID'),
            'pay_type_name' => $this->string()->notNull()->comment('支付方式'),
            'price' => $this->decimal(10,2)->notNull()->defaultValue(0.00)->comment('价格'),
            'status' => $this->integer()->defaultValue(1)->notNull()->comment('状态'),
            'create_time' => $this->integer()->notNull()->comment('订单时间')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
