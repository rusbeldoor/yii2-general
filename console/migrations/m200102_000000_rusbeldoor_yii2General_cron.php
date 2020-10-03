<?php

use yii\db\Migration;

/**
 * Class m200102_000000_rusbeldoor_yii2General_cron
 */
class m200101_000000_rusbeldoor_yii2General_bacr extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (Yii::$app->db->schema->getTableSchema('cron', true)) { $this->dropTable('cron'); }
        $this->createTable('cron', [
            'id' => $this->primaryKey(11)->unsigned(),
            'alias' => $this->string(96)->notNull(),
            'name' => $this->string(96)->notNull(),
            'status' => 'ENUM("wait", "process") NOT NULL DEFAULT "wait"',
            'active' => $this->tinyInteger(1)->notNull(),
        ]);
        $this->createIndex('unique-name', 'cron', 'name', true);

        $this->insert('auth_item', ['name' => 'backend_administrator_cron', 'type' => 2, 'description' => 'Бэкэнд, Администратор, Кроны']);
        $this->insert('auth_item_child', ['parent' => 'administrator', 'child' => 'backend_administrator_cron']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200102_000000_rusbeldoor_yii2General_cron cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200102_000000_rusbeldoor_yii2General_cron cannot be reverted.\n";

        return false;
    }
    */
}
