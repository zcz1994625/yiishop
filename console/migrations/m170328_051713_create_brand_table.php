<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m170328_051713_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('品牌名称'),
            'intro'=>$this->text()->comment('描述'),
            'logo'=>$this->string()->comment('LOGO'),
            'sort'=>$this->integer()->comment('排序'),
            'status'=>$this->integer()->comment('状态')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
