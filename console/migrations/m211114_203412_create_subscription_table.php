<?php

use console\base\Migration;
use common\models\Subscription;

/**
 * Handles the creation of table `{{%subscription_type}}`.
 */
class m211114_203412_create_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Subscription::tableName(), [
            'id'                 => $this->string(36)->notNull(),
            'userId'             => $this->string(36),
            'subscriptionTypeId' => $this->string(36),
            'isSupportMultiple'  => $this->boolean()->defaultValue(0),
            'subscriptionDate'   => $this->dateTime(),
            'remainingQuota'     => $this->double(53)->notNull(),
            'expiredAt'          => $this->dateTime(),
            'priority'           => $this->integer(10),
            'status'             => $this->string(50)->defaultValue(Subscription::STATUS_ACTIVE),
            'createdAt'          => $this->dateTime(),
            'updatedAt'          => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('subscriptionTypeId', Subscription::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Subscription::tableName());
    }
}
