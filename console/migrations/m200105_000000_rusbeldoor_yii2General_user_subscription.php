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
            'platform_id' => 'mediumint(6) UNSIGNED NOT NULL',
            'alias' => $this->string(128)->notNull()->unique(),
            'name' => $this->string(128)->notNull(),
        ]);
        $this->addForeignKey('fk-user_subscription_key-platform_id', 'user_subscription_key', 'platform_id', 'platform', 'id');

        // Таблица действий подписок пользователя
        $this->createTable('user_subscription_action', [
            'id' => 'mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'platform_id' => 'mediumint(6) UNSIGNED NOT NULL',
            'alias' => $this->string(128)->notNull()->unique(),
            'name' => $this->string(128)->notNull(),
            'active' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
        ]);
        $this->addForeignKey('fk-user_subscription_action-platform_id', 'user_subscription_action', 'platform_id', 'platform', 'id');

        // Таблица каналов подписок пользователя
        $this->createTable('user_subscription_channel', [
            'id' => 'smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'alias' => $this->string(32)->notNull()->unique(),
            'name' => $this->string(32)->notNull(),
            'active' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
        ]);

        $this->insert('user_subscription_channel', ['alias' => 'email', 'name' => 'Электронная почта', 'active' => 1]);
        $this->insert('user_subscription_channel', ['alias' => 'sms', 'name' => 'СМС', 'active' => 1]);
        $this->insert('user_subscription_channel', ['alias' => 'vkontakte', 'name' => 'ВКонтакте', 'active' => 1]);
        $this->insert('user_subscription_channel', ['alias' => 'odnoklassniki', 'name' => 'Одноклассники', 'active' => 1]);
        $this->insert('user_subscription_channel', ['alias' => 'facebook', 'name' => 'Facebook', 'active' => 1]);
        $this->insert('user_subscription_channel', ['alias' => 'instagram', 'name' => 'Instagram', 'active' => 1]);
        $this->insert('user_subscription_channel', ['alias' => 'whatsapp', 'name' => 'WhatsApp', 'active' => 1]);
        $this->insert('user_subscription_channel', ['alias' => 'viber', 'name' => 'Viber', 'active' => 1]);
        $this->insert('user_subscription_channel', ['alias' => 'telegram', 'name' => 'Telegram', 'active' => 1]);
        $this->insert('user_subscription_channel', ['alias' => 'browser', 'name' => 'Уведомления от браузера', 'active' => 1]);

        // Таблица связей пользователей с ключами подписок
        $this->createTable('user_subscription', [
            'id' => $this->primaryKey(11)->unsigned(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'key_id' =>'mediumint(8) UNSIGNED NOT NULL',
        ]);
        $this->createIndex('unique', 'user_subscription', ['user_id', 'key_id'], true);
        $this->addForeignKey('fk-user_subscription-user_id', 'user_subscription', 'user_id', 'user', 'id'); // Закомментировать, если таблица user лежит не в той же БД или имеет другое название
        $this->addForeignKey('fk-user_subscription-key_id', 'user_subscription', 'key_id', 'user_subscription_key', 'id');

        // Таблица исключений (отписок) пользователей
        $this->createTable('user_subscription_exception', [
            'id' => $this->primaryKey(11)->unsigned(),
            'subscription_id' => $this->integer(11)->unsigned()->notNull(),
            'channel_id' =>'smallint(8) UNSIGNED NOT NULL',
            'action_id' =>'mediumint(8) UNSIGNED NOT NULL',
        ]);
        $this->createIndex('unique', 'user_subscription_exception', ['subscription_id', 'channel_id', 'action_id'], true);
        $this->addForeignKey('fk-user_subscription_exception-subscription_id', 'user_subscription_exception', 'subscription_id', 'user_subscription', 'id');
        $this->addForeignKey('fk-user_subscription_exception-channel_id', 'user_subscription_exception', 'channel_id', 'user_subscription_channel', 'id');
        $this->addForeignKey('fk-user_subscription_exception-action_id', 'user_subscription_exception', 'action_id', 'user_subscription_action', 'id');
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
