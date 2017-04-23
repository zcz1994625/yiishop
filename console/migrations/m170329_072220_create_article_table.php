<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m170329_072220_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('文章名称'),
            'article_category_id'=>$this->integer()->comment('文章分类'),
            'intro'=>$this->text()->comment('描述'),
            'status'=>$this->integer()->defaultValue(1)->comment('状态'),
            'sort'=>$this->integer()->defaultValue(1)->comment('排序'),
            'input_time'=>$this->integer()->comment('加入时间')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
