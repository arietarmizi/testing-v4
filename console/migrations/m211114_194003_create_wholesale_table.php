<?php

use console\base\Migration;
use common\models\Wholesale;

/**
 * Handles the creation of table `{{%wholesale}}`.
 */
class m211114_194003_create_wholesale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Wholesale::tableName(), [
            'id'               => $this->string(36)->notNull(),
            'productVariantId' => $this->string(36),
            'minQuantity'      => $this->double(53),
            'maxQuantity'      => $this->double(53),
            'defaultPrice'     => $this->double(53),
            'status'           => $this->string(50)->defaultValue(Wholesale::STATUS_ACTIVE),
            'createdAt'        => $this->dateTime(),
            'updatedAt'        => $this->dateTime(),
        ], $this->tableOptions);
        $this->addPrimaryKey('wholesaleId', Wholesale::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Wholesale::tableName());
    }
}
