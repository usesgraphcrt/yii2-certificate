<?php

use yii\db\Schema;
use yii\db\Migration;

class m161212_124011_certificate_certificate_to_item extends Migration
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
            '{{%certificate_certificate_to_item}}',
            [
                'id'=> $this->primaryKey(11),
                'certificate_id'=> $this->integer(11)->notNull(),
                'target_model'=> $this->string(500)->notNull(),
                'target_id'=> $this->integer(11)->null()->defaultValue(null),
                'amount'=> $this->integer(11)->null()->defaultValue(null),
            ],$tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%certificate_certificate_to_item}}');
    }
}
