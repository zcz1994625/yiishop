<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_day_count`.
 */
class m170401_023936_create_goods_day_count_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_day_count', [
            'day' => $this->date()->notNull()->comment('日期'),
            'count' => $this->integer()->notNull()->comment('数量')
        ]);
        $this->addPrimaryKey('day','goods_day_count','day');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_day_count');
    }
}
