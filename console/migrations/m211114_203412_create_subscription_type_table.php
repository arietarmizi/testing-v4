<?php

use console\base\Migration;
use common\models\SubscriptionType;

/**
 * Handles the creation of table `{{%subscription_type}}`.
 */
class m211114_203412_create_subscription_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(SubscriptionType::tableName(), [
            'id'                => $this->string(36)->notNull(),
            'merchantId'        => $this->string(36),
            'isSupportMultiple' => $this->boolean()->defaultValue(0),
            'maxOutlet'         => $this->double(53)->notNull(),
            'duration'          => $this->double(53)->notNull(),
            'durationType'      => $this->string(100)->notNull()->defaultValue(SubscriptionType::DURATION_DAY),
            'description'       => $this->text(),
            'status'            => $this->string(50)->defaultValue(SubscriptionType::STATUS_ACTIVE),
            'createdAt'         => $this->dateTime(),
            'updatedAt'         => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('subscriptionTypeId', SubscriptionType::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(SubscriptionType::tableName());
    }
}
