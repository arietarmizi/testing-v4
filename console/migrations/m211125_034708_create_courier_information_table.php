<?php

use console\base\Migration;
use common\models\CourierInformation;

/**
 * Handles the creation of table `{{%courier_information}}`.
 */
class m211125_034708_create_courier_information_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(CourierInformation::tableName(), [
            'courierId'   => $this->string(36)->notNull(),
            'courierName' => $this->string(255),
            'phoneNumber' => $this->double(53),
        ], $this->tableOptions);
        $this->addPrimaryKey('courierId', CourierInformation::tableName(), ['courierId']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(CourierInformation::tableName());
    }
}
