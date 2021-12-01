<?php

use common\models\Device;
use common\models\User;
use console\base\Migration;

/**
 * Handles the creation of table `device`.
 */
class m180812_005106_create_device_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable(Device::tableName(), [
            'id'            => $this->string(36)->notNull(),
            'userId'        => $this->string(36)->notNull(),
            'accessToken'   => $this->string(255)->notNull(),
            'firebaseToken' => $this->string(255)->notNull(),
            'osType'        => $this->integer(),
            'osVersion'     => $this->string(100),
            'identifier'    => $this->string(100)->notNull(),
            'playerId'      => $this->string(255),
            'model'         => $this->string(100),
            'appVersion'    => $this->string(255),
            'latitude'      => $this->double(),
            'longitude'     => $this->double(),
            'lastIp'        => $this->string(40),
            'timezone'      => $this->string(100),
            'status'        => $this->string(50)->defaultValue(Device::STATUS_ACTIVE),
            'createdAt'     => $this->dateTime(),
            'updatedAt'     => $this->dateTime()
        ], $this->tableOptions);

        $this->addPrimaryKey('deviceId', Device::tableName(), ['id']);

        $this->addForeignKey(
            $this->formatForeignKeyName(Device::tableName(), User::tableName()),
            Device::tableName(), 'userId',
            User::tableName(), 'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('access-token-index', Device::tableName(), ['accessToken']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Device::tableName());
    }
}
