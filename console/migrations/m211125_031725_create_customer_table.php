<?php

use console\base\Migration;
use common\models\Customer;

/**
 * Handles the creation of table `{{%customer}}`.
 */
class m211125_031725_create_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Customer::tableName(), [
            'customerId'   => $this->string(36)->notNull(),
            'customerName' => $this->string(255),
            'email'        => $this->string(255),
            'phoneNumber'  => $this->double(53),
            'address'      => $this->string(255),
            'createdAt'    => $this->dateTime(),
            'updatedAt'    => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('customerId', Customer::tableName(), ['customerId']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Customer::tableName());
    }
}
