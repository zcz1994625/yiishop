<?php

use yii\db\Migration;

/**
 * Handles the creation of table `locate`.
 */
class m170411_072610_create_locate_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('locate', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->comment('收货人'),
            'provence' => $this->string()->notNull()->comment('省份'),
            'city' => $this->string()->notNull()->comment('城市'),
            'area' => $this->string()->notNull()->comment('地区'),
            'locate' => $this->string()->notNull()->comment('详细地址'),
            'tel' => $this->string(11)->notNull()->comment('手机号'),
            'status' => $this->integer(1)->defaultValue(1)->comment('是否为默认地址')

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('locate');
    }
}
