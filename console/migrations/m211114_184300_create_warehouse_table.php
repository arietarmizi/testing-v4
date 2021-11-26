<?php

use console\base\Migration;
use common\models\Warehouse;

/**
 * Handles the creation of table `{{%warehouse}}`.
 */
class m211114_184300_create_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Warehouse::tableName(), [
            'id'                     => $this->string(36)->notNull(),
            'shopId'                 => $this->string(36),
            'name'                   => $this->string(255)->notNull(),
            'description'            => $this->text(),
            'subDistrictId'             => $this->string(36),
            'address'                => $this->text(),
            'email'                  => $this->string(100)->unique()->notNull(),
            'phoneNumber'            => $this->double(50)->notNull(),
            'whType'                 => $this->string(100),
            'isDefault'              => $this->boolean()->defaultValue(0),
            'latLon'                 => $this->text(),
            'latitude'               => $this->string(255),
            'longitude'              => $this->string(255),
            'branchShopSubscription' => $this->boolean()->defaultValue(0),
            'status'                 => $this->string(50)->defaultValue(Warehouse::STATUS_ACTIVE),
            'createdAt'              => $this->dateTime(),
            'updatedAt'              => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('warehouseId', Warehouse::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Warehouse::tableName());
    }
}
