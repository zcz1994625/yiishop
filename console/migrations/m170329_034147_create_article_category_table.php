<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m170329_034147_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=> $this->string()->notNull()->comment('文章类型'),
            'intro'=> $this->text()->comment('简介'),
            'status'=> $this->integer()->defaultValue(0)->notNull()->comment('状态'),
            'sort'=> $this->integer()->defaultValue(1)->comment('排序'),
            'is_help'=> $this->integer()->defaultValue(1)->comment('是否是帮助相关的分类')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
