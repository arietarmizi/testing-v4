<?php

use console\base\Migration;
use common\models\SubscriptionType;

/**
 * Handles the creation of table `{{%subscription_type}}`.
 */
class m211125_033435_create_subscription_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(SubscriptionType::tableName(), [
            'id'               => $this->string(36)->notNull(),
            'price'            => $this->double(53),
            'duration'         => $this->double(53),
            'durationType'     => $this->string(50),
            'transactionQuota' => $this->double(53),
            'description'      => $this->text(),
            'status'           => $this->string(50)->defaultValue(SubscriptionType::STATUS_ACTIVE),
            'createdAt'        => $this->dateTime(),
            'updatedAt'        => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('subscriptionTypesId', SubscriptionType::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(SubscriptionType::tableName());
    }
}
