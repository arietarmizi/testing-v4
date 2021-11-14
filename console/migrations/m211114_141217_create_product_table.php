<?php

use console\base\Migration;
use common\models\Product;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m211114_141217_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Product::tableName(), [
            'id'           => $this->string(36)->notNull(),
            'sku'          => $this->string(50)->notNull(),
            'shopId'       => $this->string(36),
            'categoryId'   => $this->string(36),
            'code'         => $this->string(50),
            'name'         => $this->string(255)->notNull(),
            'condition'    => $this->string(50)->defaultValue(Product::CONDITION_NEW),
            'description'  => $this->text(),
            'minimumOrder' => $this->double(53),
            'status'       => $this->string(50)->defaultValue(Product::STATUS_ACTIVE),
            'createdAt'    => $this->dateTime(),
            'updatedAt'    => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('productId', Product::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Product::tableName());
    }
}
