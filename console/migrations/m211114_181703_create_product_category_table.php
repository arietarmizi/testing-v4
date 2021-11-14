<?php

use console\base\Migration;
use common\models\ProductCategory;

/**
 * Handles the creation of table `{{%product_category}}`.
 */
class m211114_181703_create_product_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(ProductCategory::tableName(), [
            'id'        => $this->string(36)->notNull(),
            'name'      => $this->string(255)->notNull(),
            'status'    => $this->string(50)->defaultValue(ProductCategory::STATUS_ACTIVE),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('productCategoryId', ProductCategory::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(ProductCategory::tableName());
    }
}
