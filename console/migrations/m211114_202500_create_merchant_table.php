<?php

use console\base\Migration;
use common\models\Merchant;

/**
 * Handles the creation of table `{{%merchant}}`.
 */
class m211114_202500_create_merchant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Merchant::tableName(), [
            'id'             => $this->string(36)->notNull(),
            'userId'         => $this->string(36)->notNull(),
            'code'           => $this->string(50),
            'name'           => $this->string(255)->notNull(),
            'description'    => $this->text(),
            'registerStatus' => $this->string(100)->defaultValue(Merchant::REGISTER_NEW),
            'registeredAt'   => $this->date(),
            'status'         => $this->string(50)->defaultValue(Merchant::STATUS_ACTIVE),
            'createdAt'      => $this->dateTime(),
            'updatedAt'      => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('merchantId', Merchant::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Merchant::tableName());
    }
}
