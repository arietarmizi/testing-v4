<?php

use console\base\Migration;
use common\models\Warehouse;

/**
 * Handles the creation of table `{{%warehouse}}`.
 */
class m211114_184300_create_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Warehouse::tableName(), [
            'id'         => $this->string(36)->notNull(),
            'districtId' => $this->string(36),
            'name'       => $this->string(255)->notNull(),
            'address'    => $this->string(255),
            'type'       => $this->string(50)->defaultValue(Warehouse::STORE),
            'status'     => $this->string(50)->defaultValue(Warehouse::STATUS_ACTIVE),
            'createdAt'  => $this->dateTime(),
            'updatedAt'  => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('warehouseId', Warehouse::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Warehouse::tableName());
    }
}
