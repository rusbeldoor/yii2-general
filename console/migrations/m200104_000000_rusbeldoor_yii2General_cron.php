<?php

use yii\db\Migration;

/**
 * Class m200104_000000_rusbeldoor_yii2General_rbac
 */
class m200104_000000_rusbeldoor_yii2General_cron extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица кронов
        $this->createTable('cron', [
            'id' => $this->primaryKey(11)->unsigned(),
            'alias' => $this->string(96)->notNull(),
            'description' => $this->text()->notNull(),
            'status' => 'ENUM("wait", "process") NOT NULL DEFAULT "wait"',
            'max_duration' => $this->integer(11)->unsigned()->defaultValue(null),
            'kill_process' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
            'restart' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
            'active' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
        ]);
        $this->createIndex('unique-alias', 'cron', 'alias', true);

        // Таблица логов по кронам
        $this->createTable('cron_log', [
            'id' => $this->primaryKey(11)->unsigned(),
            'cron_id' => $this->integer(11)->unsigned()->notNull(),
            'duration' => $this->integer(11)->unsigned()->defaultValue(null),
            'datetime_start' => $this->datetime()->notNull(),
            'datetime_complete' => $this->datetime()->defaultValue(null),
            'pid' => $this->string(32)->defaultValue(null),
        ]);
        $this->addForeignKey('fk-cron_id', 'cron_log', 'cron_id', 'cron', 'id');

        // Крон
        $this->insert('cron', ['alias' => 'remove-outdated-data', 'description' => 'Удаление устаревших данных', 'status' => 'wait', 'max_duration' => 3600, 'kill_process' => 1, 'restart' => 1, 'active' => 1]);

        // Создание ролей, операций
        $this->insert('auth_item', ['name' => 'cron', 'type' => 2, 'description' => 'Кроны']);
        $this->insert('auth_item_child', ['parent' => 'administrator', 'child' => 'cron']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200104_000000_rusbeldoor_yii2General_rbac cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200104_000000_rusbeldoor_yii2General_rbac cannot be reverted.\n";

        return false;
    }
    */
}
