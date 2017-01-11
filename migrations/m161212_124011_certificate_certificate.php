<?php

use yii\db\Schema;
use yii\db\Migration;

class m161212_124011_certificate_certificate extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%certificate_certificate}}',
            [
                'id'=> $this->primaryKey(11),
                'code'=> $this->string(255)->notNull(),
                'type'=> $this->string()->notNull(),
                'created_at'=> $this->datetime()->notNull(),
                'date_elapsed'=> $this->datetime()->null()->defaultValue(null),
                'employment'=> $this->string(55)->notNull(),
                'status'=> $this->string()->notNull(),
                'owner_id'=> $this->integer(11)->notNull(),
                'target_user'=> $this->integer(11)->null(),
            ],$tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%certificate_certificate}}');
    }
}
