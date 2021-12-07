<?php

use console\base\Migration;
use common\models\Product;
use common\models\ProductImages;

/**
 * Handles the creation of table `{{%product_images}}`.
 */
class m211206_125019_create_product_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(ProductImages::tableName(), [
            'id'        => $this->string(36)->notNull(),
            'productId' => $this->string(36)->notNull(),
            'fileId'    => $this->integer()->notNull(),
            'isPrimary' => $this->boolean()->defaultValue(0),
            'status'    => $this->string(50)->defaultValue(ProductImages::STATUS_ACTIVE),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('productGalleriesId', ProductImages::tableName(), ['id']);

        $this->addForeignKey($this->formatForeignKeyName(
            ProductImages::tableName(), Product::tableName()),
            ProductImages::tableName(), 'productId',
            Product::tableName(), 'id',
            'CASCADE', 'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(ProductImages::tableName());
    }
}
