<?php

use yii\db\Migration;

/**
 * Class m200103_000000_rusbeldoor_yii2General_cron
 */
class m200103_000000_rusbeldoor_yii2General_cron extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица кронов
        if (Yii::$app->db->schema->getTableSchema('cron', true)) { $this->dropTable('cron'); }
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
        if (Yii::$app->db->schema->getTableSchema('cron_log', true)) { $this->dropTable('cron_log'); }
        $this->createTable('cron_log', [
            'id' => $this->primaryKey(11)->unsigned(),
            'cron_id' => $this->integer(11)->unsigned()->notNull(),
            'duration' => $this->integer(11)->unsigned()->defaultValue(null),
            'datetime_start' => $this->datetime()->notNull(),
            'datetime_complete' => $this->datetime()->defaultValue(null),
            'pid' => $this->string(32)->defaultValue(null),
        ]);
        $this->addForeignKey('fk-cron-cron_log', 'cron_log', 'cron_id', 'cron', 'id');

        // Создание ролей, операций
        $this->insert('auth_item', ['name' => 'rusbeldoor-cron', 'type' => 2, 'description' => 'Rusbeldoor, Кроны']);
        $this->insert('auth_item_child', ['parent' => 'administrator', 'child' => 'rusbeldoor-cron']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200103_000000_rusbeldoor_yii2General_cron cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200103_000000_rusbeldoor_yii2General_cron cannot be reverted.\n";

        return false;
    }
    */
}
