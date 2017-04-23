<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170402_025339_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'username'=>$this->string()->notNull()->comment('姓名'),
            'password'=>$this->string()->notNull()->comment('密码'),
            'salt'=>$this->string()->notNull()->comment('盐'),
            'email'=>$this->string()->notNull()->comment('邮箱'),
            'token'=>$this->string()->notNull()->comment('自动登录令牌'),
            'token_create_time'=>$this->integer()->comment('令牌创建时间'),
            'add_time'=>$this->integer()->notNull()->comment('注册时间'),
            'last_login_time'=>$this->integer()->notNull()->comment('最后登录时间'),
            'last_login_ip'=>$this->string()->comment('最后登录ip')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
