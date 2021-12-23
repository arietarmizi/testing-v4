<?php

use common\models\ProductImages;
use common\models\ProductVariant;
use console\base\Migration;

/**
 * Handles the creation of table `{{%product_image}}`.
 */
class m211223_055241_modify_product_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
			$this->dropForeignKey('fk_product_images_product',ProductImages::tableName());
        $this->dropColumn(ProductImages::tableName(), 'productId');
        $this->addColumn(ProductImages::tableName(), 'productVariantId', $this->string(36)->notNull());
        $this->addForeignKey('fk_product_image_product_variant', ProductImages::tableName(),
					'productVariantId', ProductVariant::tableName(), 'id',
					'CASCADE', 'CASCADE'
				);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
			$this->dropColumn(ProductImages::tableName(), 'productVariantId');
    }
}
