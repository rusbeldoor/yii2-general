<?php

use yii\db\Migration;

/**
 * Class m200105_000000_rusbeldoor_yii2General_user_subscription
 */
class m200105_000000_rusbeldoor_yii2General_user_subscription extends Migration
{
    /** {@inheritdoc} */
    public function safeUp()
    {
        // Таблица категорий отправителей
        $this->createTable('user_subscription_sender_category', [
            'id' => 'mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'platform_id' => 'smallint(6) UNSIGNED NOT NULL',
            'alias' => $this->string(128)->notNull(),
            'name' => $this->string(128)->notNull(),
        ]);
        $this->createIndex('unique', 'user_subscription_sender_category', ['platform_id', 'alias'], true);
        $this->addForeignKey('fk-platform_id', 'user_subscription_sender_category', 'platform_id', 'platform', 'id');

        // Таблица отправителей
        $this->createTable('user_subscription_sender', [
            'id' => 'mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'category_id' => 'mediumint(8) UNSIGNED NOT NULL',
            'key' => $this->string(16),
            'name' => $this->string(128)->notNull(),
            'active' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
        ]);
        $this->addForeignKey('fk-category_id', 'user_subscription_sender', 'category_id', 'user_subscription_sender_category', 'id');

        // Таблица способов доставки сообщений
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

        // Таблица действий распростроняющиеся на всех участников категорий
        $this->createTable('user_subscription_sender_category_action', [
            'id' => 'mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'category_id' => 'mediumint(8) UNSIGNED',
            'alias' => $this->string(128)->notNull()->unique(),
            'name' => $this->string(128)->notNull(),
            'active' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
        ]);
        $this->addForeignKey('fk-category_id', 'user_subscription_sender_category_action', 'category_id', 'user_subscription_sender_category', 'id');

        // Таблица связей пользователей с отправителями
        $this->createTable('user_subscription', [
            'id' => $this->primaryKey(11)->unsigned(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'sender_id' => 'mediumint(8) UNSIGNED NOT NULL',
            'active' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
        ]);
        $this->createIndex('unique', 'user_subscription', ['user_id', 'sender_id'], true);
        $this->addForeignKey('fk-user_id', 'user_subscription', 'user_id', 'user', 'id'); // Закомментировать, если таблица user лежит не в той же БД или имеет другое название
        $this->addForeignKey('fk-sender_id', 'user_subscription', 'sender_id', 'user_subscription_sender', 'id');

        // Таблица исключений (отписок) пользователей
        $this->createTable('user_subscription_exception', [
            'id' => $this->primaryKey(11)->unsigned(),
            'subscription_id' => $this->integer(11)->unsigned()->notNull(),
            'sender_category_action_id' => 'mediumint(8) UNSIGNED NOT NULL',
            'channel_id' => 'smallint(8) UNSIGNED NOT NULL',
        ]);
        $this->createIndex('unique', 'user_subscription_exception', ['subscription_id', 'sender_category_action_id', 'channel_id'], true);
        $this->addForeignKey('fk-subscription_id', 'user_subscription_exception', 'subscription_id', 'user_subscription', 'id');
        $this->addForeignKey('fk-sender_category_action_id', 'user_subscription_exception', 'sender_category_action_id', 'user_subscription_sender_category_action', 'id');
        $this->addForeignKey('fk-channel_id', 'user_subscription_exception', 'channel_id', 'user_subscription_channel', 'id');

        // Таблица связей пользователей с отправителями
        $this->createTable('user_subscription_log', [
            'id' => $this->primaryKey(11)->unsigned(),
            'subscription_id' => $this->integer(11)->unsigned()->notNull(),
            'time_add' => $this->integer(11)->unsigned()->notNull(),
            'data' => $this->text()->defaultValue(null),
        ]);

        // Таблица связей пользователей с отправителями
        $this->createTable('user_subscription_exception_log', [
            'id' => $this->primaryKey(11)->unsigned(),
            'exception_id' => $this->integer(11)->unsigned()->notNull(),
            'time_add' => $this->integer(11)->unsigned()->notNull(),
            'data' => $this->text()->defaultValue(null),
        ]);
    }

    /** {@inheritdoc} */
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
