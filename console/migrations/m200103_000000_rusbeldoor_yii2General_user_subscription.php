<?php

use yii\db\Migration;

/**
 * Class m200103_000000_rusbeldoor_yii2General_user_subscription
 */
class m200103_000000_rusbeldoor_yii2General_user_subscription extends Migration
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
            'key_id' => $this->integer(11)->unsigned()->notNull(),
            'channel_id' => $this->integer(11)->unsigned()->notNull(),
        ]);
        $this->createIndex('unique', 'user_subscription', ['user_id', 'key_id', 'channel_id'], true);
        $this->addForeignKey('fk-user_subscription-user_subscription_key', 'user_subscription', 'key_id', 'user_subscription_key', 'id');
        $this->addForeignKey('fk-user_subscription-user_subscription_channel', 'user_subscription', 'channel_id', 'user_subscription_channel', 'id');

        // Тестовые данные
        for ($key_id = 1; $key_id <= 10; $key_id++) { $this->insert('user_subscription_key', ['id' => $key_id, 'key' => 'key-' . $key_id]); }
        for ($channel_id = 1; $channel_id <= 10; $channel_id++) { $this->insert('user_subscription_channel', ['id' => $channel_id, 'channel' => 'channel-' . $channel_id]); }
        for ($user_id = 100000; $user_id < 101000; $user_id++) {
            $this->insert('users', ['id' => $user_id, 'email' => 'name' . $user_id . '@gmail.com']);
            for ($key_id = 1; $key_id <= 10; $key_id++) {
                for ($channel_id = 1; $channel_id <= 10; $channel_id++) {
                    $this->insert('user_subscription', ['user_id' => $user_id, 'key_id' => $key_id, 'channel_id' => $channel_id]);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200103_000000_rusbeldoor_yii2General_user_subscription cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200103_000000_rusbeldoor_yii2General_user_subscription cannot be reverted.\n";

        return false;
    }
    */
}
