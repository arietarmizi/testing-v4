<?php

use console\base\Migration;
use common\models\StockManagement;

/**
 * Handles the creation of table `{{%product_stock}}`.
 */
class m211114_194800_create_stock_management_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(StockManagement::tableName(), [
            'id'               => $this->string(36)->notNull(),
            'warehouseId'      => $this->string(36),
            'productVariantId' => $this->string(36),
            'warehouseStock'   => $this->string(50),
            'backupStock'      => $this->double(53),
            'lockedStock'      => $this->double(53),
            'promotionStock'   => $this->double(53),
            'availableStock'   => $this->double(53),
            'stockTypeId'      => $this->string(36),
            'status'           => $this->string(50)->defaultValue(StockManagement::STATUS_ACTIVE),
            'createdAt'        => $this->dateTime(),
            'updatedAt'        => $this->dateTime(),
        ], $this->tableOptions);


        $this->addPrimaryKey('productStockId', StockManagement::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(StockManagement::tableName());
    }
}
