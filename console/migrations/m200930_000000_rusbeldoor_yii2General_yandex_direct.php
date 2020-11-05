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
        if (Yii::$app->db->schema->getTableSchema('yandex_direct_campaign', true)) { $this->dropTable('yandex_direct_campaign'); }
        $this->createTable('yandex_direct_campaign', [
            'id' => $this->primaryKey(11)->unsigned(),
            'name' => $this->varchar(255)->notNull(),
            'status' => $this->varchar(16)->notNull(),
            'state' => $this->varchar(16)->notNull(),
        ]);

        // Таблица групп объявлений Яндекс.Директ
        if (Yii::$app->db->schema->getTableSchema('yandex_direct_adgroup', true)) { $this->dropTable('yandex_direct_campaign'); }
        $this->createTable('user_subscription', [
            'id' => $this->primaryKey(11)->unsigned(),
            'campaign_id' => $this->integer(11)->unsigned()->notNull(),
            'name' => $this->varchar(255)->notNull(),
            'status' => $this->varchar(16)->notNull(),
        ]);
        $this->addForeignKey('fk-yandex_direct_adgroup-campaign_id', 'yandex_direct_adgroup', 'campaign_id', 'yandex_direct_campaign', 'id');

        // Таблица объявлений Яндекс.Директ
        if (Yii::$app->db->schema->getTableSchema('yandex_direct_ad', true)) { $this->dropTable('yandex_direct_ad'); }
        $this->createTable('yandex_direct_ad', [
            'id' => $this->primaryKey(11)->unsigned(),
            'campaign_id' => $this->integer(11)->unsigned()->notNull(),
            'adgroup_id' => $this->integer(11)->unsigned()->notNull(),
            'title' => $this->varchar(255)->notNull(),
            'status' => $this->varchar(16)->notNull(),
            'state' => $this->varchar(16)->notNull(),
        ]);
        $this->addForeignKey('fk-yandex_direct_ad-campaign_id', 'yandex_direct_ad', 'campaign_id', 'yandex_direct_campaign', 'id');
        $this->addForeignKey('fk-yandex_direct_ad-adgroup_id', 'yandex_direct_ad', 'adgroup_id', 'yandex_direct_adgroup', 'id');
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
