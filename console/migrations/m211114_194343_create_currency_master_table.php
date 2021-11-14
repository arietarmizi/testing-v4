<?php

use console\base\Migration;
use common\models\CurrencyMaster;

/**
 * Handles the creation of table `{{%currency_master}}`.
 */
class m211114_194343_create_currency_master_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(CurrencyMaster::tableName(), [
            'id'        => $this->string(36)->notNull(),
            'name'      => $this->string(255)->notNull(),
            'status'    => $this->string(50)->defaultValue(CurrencyMaster::STATUS_ACTIVE),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('currencyMasterId', CurrencyMaster::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(CurrencyMaster::tableName());
    }
}
