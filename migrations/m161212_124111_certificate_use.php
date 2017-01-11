<?php

use yii\db\Schema;
use yii\db\Migration;

class m161212_124111_certificate_use extends Migration
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
            '{{%certificate_use}}',
            [
                'id'=> $this->primaryKey(11),
                'certificate_id'=> $this->integer(11)->notNull(),
                'date'=> $this->datetime()->notNull(),
                'amount'=> $this->decimal(12, 2)->notNull(),
                'balance'=> $this->decimal(12, 2)->notNull(),
                'item_id'=> $this->integer(11),
                'order_id'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%certificate_use}}');
    }
}
