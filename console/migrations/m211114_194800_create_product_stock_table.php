<?php

use console\base\Migration;
use common\models\ProductStock;

/**
 * Handles the creation of table `{{%product_stock}}`.
 */
class m211114_194800_create_product_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(ProductStock::tableName(), [
            'id'               => $this->string(36)->notNull(),
            'sku'              => $this->string(100),
            'productVariantId' => $this->string(36),
            'warehouseId'      => $this->string(36),
            'stockType'        => $this->string(50),
            'quantity'         => $this->double(53),
            'status'           => $this->string(50)->defaultValue(ProductStock::STATUS_ACTIVE),
            'createdAt'        => $this->dateTime(),
            'updatedAt'        => $this->dateTime(),
        ], $this->tableOptions);


        $this->addPrimaryKey('productStockId', ProductStock::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(ProductStock::tableName());
    }
}
