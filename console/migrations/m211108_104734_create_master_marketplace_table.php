<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%master_marketplace}}`.
 */
class m211108_104734_create_master_marketplace_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%master_marketplace}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%master_marketplace}}');
    }
}
