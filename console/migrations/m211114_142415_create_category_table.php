<?php

use console\base\Migration;
use common\models\Category;

/**
 * Handles the creation of table `{{%product_category}}`.
 */
class m211114_142415_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Category::tableName(), [
            'id'        => $this->string(36)->notNull(),
            'name'      => $this->string(255)->notNull(),
            'parentId'  => $this->string(36),
            'status'    => $this->string(50)->defaultValue(Category::STATUS_ACTIVE),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('categoryId', Category::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Category::tableName());
    }
}
