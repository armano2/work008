<?php

use yii\db\Schema;
use yii\db\Migration;

class m150605_213206_contact extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contact}}', [
            'id'                    => Schema::TYPE_PK,
            'user_id'               => Schema::TYPE_INTEGER,
            'message'               => Schema::TYPE_TEXT . ' NOT NULL',
            // TODO: more fields??? like time???
        ], $tableOptions);
        $this->addForeignKey('fk_user_contact', '{{%contact}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%contact}}');
    }

}
