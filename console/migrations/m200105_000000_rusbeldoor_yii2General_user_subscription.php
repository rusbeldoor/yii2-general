<?php

use yii\db\Migration;

/**
 * Class m200105_000000_rusbeldoor_yii2General_user_subscription
 */
class m200105_000000_rusbeldoor_yii2General_user_subscription extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица ключей подписок пользователя
        $this->createTable('user_subscription_key', [
            'id' => 'mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'alias' => $this->string(128)->notNull()->unique(),
            'name' => $this->string(128)->notNull(),
        ]);

        // Таблица каналов подписок пользователя
        $this->createTable('user_subscription_channel', [
            'id' => 'smallint(6) z NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'alias' => $this->string(32)->notNull()->unique(),
            'name' => $this->string(32)->notNull(),
        ]);

        $this->insert('user_subscription_channel', ['alias' => 'email', 'name' => 'Электронная почта']);
        $this->insert('user_subscription_channel', ['alias' => 'sms', 'name' => 'СМС']);
        $this->insert('user_subscription_channel', ['alias' => 'vkontakte', 'name' => 'ВКонтакте']);
        $this->insert('user_subscription_channel', ['alias' => 'odnoklassniki', 'name' => 'Одноклассники']);
        $this->insert('user_subscription_channel', ['alias' => 'facebook', 'name' => 'Facebook']);
        $this->insert('user_subscription_channel', ['alias' => 'instagram', 'name' => 'Instagram']);
        $this->insert('user_subscription_channel', ['alias' => 'whatsapp', 'name' => 'WhatsApp']);
        $this->insert('user_subscription_channel', ['alias' => 'viber', 'name' => 'Viber']);
        $this->insert('user_subscription_channel', ['alias' => 'telegram', 'name' => 'Telegram']);
        $this->insert('user_subscription_channel', ['alias' => 'browser', 'name' => 'Уведомления от браузера']);

        // Таблица подписок пользователя
        $this->createTable('user_subscription', [
            'id' => $this->primaryKey(11)->unsigned(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'key_id' =>'mediumint(8) UNSIGNED NOT NULL',
            'channel_id' => $this->smallInteger(6)->unsigned()->notNull(),
            'active' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
        ]);
        $this->createIndex('unique', 'user_subscription', ['user_id', 'key_id', 'channel_id'], true);
        $this->addForeignKey('fk-user_subscription-user_id', 'user_subscription', 'user_id', 'user', 'id'); // Закомментировать, если таблица user лежит не в той же БД или имеет другое название
        $this->addForeignKey('fk-user_subscription-key_id', 'user_subscription', 'key_id', 'user_subscription_key', 'id');
        $this->addForeignKey('fk-user_subscription-channel_id', 'user_subscription', 'channel_id', 'user_subscription_channel', 'id');

        // Тестовые данные
        /*
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
        */
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200105_000000_rusbeldoor_yii2General_user_subscription cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200105_000000_rusbeldoor_yii2General_user_subscription cannot be reverted.\n";

        return false;
    }
    */
}
