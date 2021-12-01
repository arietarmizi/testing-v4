<?php

use common\models\ForgotPassword;
use common\models\User;
use console\base\Migration;


/**
 * Handles the creation of table `forgot_password`.
 */
class m180812_005135_create_forgot_password_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(ForgotPassword::tableName(), [
            'id'         => $this->string(36)->notNull(),
            'userId'     => $this->string(36)->notNull(),
            'code'       => $this->string(10)->notNull(),
            'status'     => $this->string(50)->notNull()->defaultValue(ForgotPassword::STATUS_ACTIVE),
            'identifier' => $this->string(100),
            'ip'         => $this->string(100)->notNull(),
            'usedAt'     => $this->dateTime(),
            'createdAt'  => $this->dateTime(),
            'updatedAt'  => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('forgotPasswordId', ForgotPassword::tableName(), ['id']);

        $this->addForeignKey(
            $this->formatForeignKeyName(ForgotPassword::tableName(), User::tableName()),
            ForgotPassword::tableName(), 'userId',
            User::tableName(), 'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(ForgotPassword::tableName());
    }
}
