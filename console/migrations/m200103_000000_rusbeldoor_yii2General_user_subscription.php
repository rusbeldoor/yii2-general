<?php

use yii\db\Migration;

/**
 * Class m200102_000000_rusbeldoor_yii2General_user_subscription
 */
class m200102_000000_rusbeldoor_yii2General_user_subscription extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица ключей подписок пользователя
        $this->createTable('user_subscription_key', [
            'id' => $this->primaryKey(11)->unsigned(),
            'key' => $this->string(128)->notNull(),
        ]);
        $this->createIndex('unique', 'user_subscription_key', 'key', true);

        // Таблица каналов подписок пользователя
        $this->createTable('user_subscription_channel', [
            'id' => $this->primaryKey(11)->unsigned(),
            'channel' => $this->string(32)->notNull(),
        ]);
        $this->createIndex('unique', 'user_subscription_channel', 'channel', true);

        // Таблица подписок пользователя
        $this->createTable('user_subscription', [
            'id' => $this->primaryKey(11)->unsigned(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'user_subscription_key_id' => $this->int(11)->unsigned()->notNull(),
            'user_subscription_channel_id' => $this->int(11)->unsigned()->notNull(),
        ]);
        $this->createIndex('unique', 'user_subscription', ['user_id', 'key_id', 'channel_id'], true);
        $this->addForeignKey('fk-user_subscription-user_subscription_key', 'user_subscription', 'user_subscription_key_id', 'user_subscription_key', 'id');
        $this->addForeignKey('fk-user_subscription-user_subscription_channel', 'user_subscription', 'user_subscription_channel_id', 'user_subscription_channel', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200102_000000_rusbeldoor_yii2General_user_subscription cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200102_000000_rusbeldoor_yii2General_user_subscription cannot be reverted.\n";

        return false;
    }
    */
}
