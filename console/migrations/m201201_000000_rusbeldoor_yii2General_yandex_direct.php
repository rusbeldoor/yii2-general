<?php

use yii\db\Migration;

/**
 * Class m201201_000000_rusbeldoor_yii2General_yandex_direct
 */
class m201201_000000_rusbeldoor_yii2General_yandex_direct extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица аккаунтов Яндекс.Директ
        $this->createTable('yandex_direct_account', [
            'id' => $this->primaryKey(11)->unsigned(),
            'name' => $this->string(64)->notNull(),
            'url' => $this->string(96)->notNull(),
            'login' => $this->string(64)->notNull(),
            'token' => $this->string(64)->notNull(),
        ]);

        // Таблица компаний Яндекс.Директ
        $this->createTable('yandex_direct_campaign', [
            'id' => 'varchar(16) NOT NULL PRIMARY KEY',
            'account_id' => $this->integer(11)->unsigned()->notNull(),
            'name' => $this->string(128)->notNull(),
            'status' => $this->string(16)->notNull(),
            'state' => $this->string(16)->notNull(),
        ]);
        $this->addForeignKey('fk-yandex_direct_campaign-account_id', 'yandex_direct_campaign', 'account_id', 'yandex_direct_account', 'id');

        // Таблица групп объявлений Яндекс.Директ
        $this->createTable('yandex_direct_adgroup', [
            'id' => 'varchar(16) NOT NULL PRIMARY KEY',
            'account_id' => $this->integer(11)->unsigned()->notNull(),
            'campaign_id' => $this->string(16)->notNull(),
            'name' => $this->string(128)->notNull(),
            'status' => $this->string(16)->notNull(),
        ]);
        $this->addForeignKey('fk-yandex_direct_adgroup-account_id', 'yandex_direct_adgroup', 'account_id', 'yandex_direct_account', 'id');
        $this->addForeignKey('fk-yandex_direct_adgroup-campaign_id', 'yandex_direct_adgroup', 'campaign_id', 'yandex_direct_campaign', 'id');

        // Таблица объявлений Яндекс.Директ
        $this->createTable('yandex_direct_ad', [
            'id' => 'varchar(16) NOT NULL PRIMARY KEY',
            'account_id' => $this->integer(11)->unsigned()->notNull(),
            'campaign_id' => $this->string(16)->notNull(),
            'adgroup_id' => $this->string(16)->notNull(),
            'title' => $this->string(128)->notNull(),
            'status' => $this->string(16)->notNull(),
            'state' => $this->string(16)->notNull(),
        ]);
        $this->addForeignKey('fk-yandex_direct_ad-account_id', 'yandex_direct_ad', 'account_id', 'yandex_direct_account', 'id');
        $this->addForeignKey('fk-yandex_direct_ad-campaign_id', 'yandex_direct_ad', 'campaign_id', 'yandex_direct_campaign', 'id');
        $this->addForeignKey('fk-yandex_direct_ad-adgroup_id', 'yandex_direct_ad', 'adgroup_id', 'yandex_direct_adgroup', 'id');

        // Таблица логов Яндекс.Директ
        $this->createTable('yandex_direct_log', [
            'id' => $this->primaryKey(11)->unsigned(),
            'user_id' => $this->integer(11)->unsigned()->defaultValue(null),
            'elem_type' => 'ENUM("account", "campaign", "adgroup", "ad") NOT NULL',
            'elem_id' => 'varchar(16) NOT NULL',
            'datetime' => $this->datetime()->notNull(),
            'action' => $this->string(32)->notNull(),
        ]);
        $this->addForeignKey('fk-yandex_direct_log-user_id', 'yandex_direct_log', 'user_id', 'user', 'id'); // Закомментировать, если таблица user лежит не в той же БД или имеет другое название

        // Крон
        $this->insert('cron', ['alias' => 'yandex-direct', 'description' => 'Яндекс.Директ', 'status' => 'wait', 'max_duration' => 600, 'kill_process' => 1, 'restart' => 1, 'active' => 1]);

        // Создание ролей, операций
        $this->insert('auth_item', ['name' => 'yandex-direct', 'type' => 2, 'description' => 'Яндекс.Директ']);
        $this->insert('auth_item_child', ['parent' => 'administrator', 'child' => 'yandex-direct']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201201_000000_rusbeldoor_yii2General_yandex_direct cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201201_000000_rusbeldoor_yii2General_yandex_direct cannot be reverted.\n";

        return false;
    }
    */
}
