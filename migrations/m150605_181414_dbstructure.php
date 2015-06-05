<?php

use yii\db\Schema;
use yii\db\Migration;

class m150605_181414_dbstructure extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'                   => Schema::TYPE_PK,
            'email'                => Schema::TYPE_STRING . '(255) NOT NULL',
            'password_hash'        => Schema::TYPE_STRING . '(60) NOT NULL',
            'auth_key'             => Schema::TYPE_STRING . '(32) NOT NULL',
        ], $tableOptions);

        $this->createIndex('user_unique_email', '{{%user}}', 'email', true);

        $this->createTable('{{%profile}}', [
            'user_id'        => Schema::TYPE_INTEGER . ' PRIMARY KEY',
            'name'           => Schema::TYPE_STRING . '(255)',
            'surname'        => Schema::TYPE_STRING . '(255)',
        ], $tableOptions);
        $this->addForeignKey('fk_user_profile', '{{%profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%user}}');
    }

}
