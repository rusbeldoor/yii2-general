<?php

use yii\db\Migration;

/**
 * Class m200930_000000_rusbeldoor_yii2General_yandex_direct.php
 */
class m200930_000000_rusbeldoor_yii2General_yandex_direct extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица компаний Яндекс.Директ
        $this->createTable('yandex_direct_campaign', [
            'id' => $this->primaryKey(11)->unsigned(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->string(16)->notNull(),
            'state' => $this->string(16)->notNull(),
        ]);

        // Таблица групп объявлений Яндекс.Директ
        $this->createTable('yandex_direct_adgroup', [
            'id' => $this->primaryKey(11)->unsigned(),
            'campaign_id' => $this->integer(11)->unsigned()->notNull(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->string(16)->notNull(),
        ]);
        $this->addForeignKey('fk-yandex_direct_adgroup-campaign_id', 'yandex_direct_adgroup', 'campaign_id', 'yandex_direct_campaign', 'id');

        // Таблица объявлений Яндекс.Директ
        $this->createTable('yandex_direct_ad', [
            'id' => $this->primaryKey(11)->unsigned(),
            'campaign_id' => $this->integer(11)->unsigned()->notNull(),
            'adgroup_id' => $this->integer(11)->unsigned()->notNull(),
            'title' => $this->string(255)->notNull(),
            'status' => $this->string(16)->notNull(),
            'state' => $this->string(16)->notNull(),
        ]);
        $this->addForeignKey('fk-yandex_direct_ad-campaign_id', 'yandex_direct_ad', 'campaign_id', 'yandex_direct_campaign', 'id');
        $this->addForeignKey('fk-yandex_direct_ad-adgroup_id', 'yandex_direct_ad', 'adgroup_id', 'yandex_direct_adgroup', 'id');

        // Крон
        $this->insert('cron', ['alias' => 'yandex-direct', 'description' => 'Яндекс.Директ', 'status' => 'wait', 'max_duration' => 3600, 'kill_process' => 1, 'restart' => 1, 'active' => 1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200930_000000_rusbeldoor_yii2General_yandex_direct.php cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200930_000000_rusbeldoor_yii2General_yandex_direct.php cannot be reverted.\n";

        return false;
    }
    */
}
