<?php

use console\base\Migration;
use common\models\ProductCategoryDetail;

/**
 * Handles the creation of table `{{%product_category_detail}}`.
 */
class m211114_181714_create_product_category_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(ProductCategoryDetail::tableName(), [
            'id'                => $this->string(36)->notNull(),
            'productCategoryId' => $this->string(36),
            'name'              => $this->string(255)->notNull(),
            'status'            => $this->string(50)->defaultValue(ProductCategoryDetail::STATUS_ACTIVE),
            'createdAt'         => $this->dateTime(),
            'updatedAt'         => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('productCategoryDetailId', ProductCategoryDetail::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(ProductCategoryDetail::tableName());
    }
}
