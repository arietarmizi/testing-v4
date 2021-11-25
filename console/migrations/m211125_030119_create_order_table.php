<?php

use console\base\Migration;
use common\models\Order;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m211125_030119_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Order::tableName(), [
            'orderId'     => $this->string(36)->notNull(),
            'orderDate'   => $this->dateTime(),
            'shopId'      => $this->string(100),
            'revInv'      => $this->string(100),
            'customerId'  => $this->string(36),
            'courierId'   => $this->string(36),
            'warehouseId' => $this->string(36),
            'promoId'     => $this->string(36),
            'discountId'  => $this->string(36),
            'orderStatus' => $this->string(50),
        ], $this->tableOptions);
        $this->addPrimaryKey('orderId', Order::tableName(), ['orderId']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Order::tableName());
    }
}
