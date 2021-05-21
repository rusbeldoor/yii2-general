<?php

use yii\db\Migration;

/**
 * Class m200103_000000_rusbeldoor_yii2General_platform
 */
class m200103_000000_rusbeldoor_yii2General_platform extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица платформ
        $this->createTable('platform', [
            'id' => $this->primaryKey(11)->unsigned(),
            'alias' => $this->string(16)->notNull(),
            'name' => $this->string(32)->notNull(),
        ]);
        $this->createIndex('unique', 'platform', ['alias'], true);

        // Создание ролей, операций
        $this->insert('auth_item', ['name' => 'platform', 'type' => 2, 'description' => 'Платформы']);
        $this->insert('auth_item_child', ['parent' => 'administrator', 'child' => 'platform']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200103_000000_rusbeldoor_yii2General_platform cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200103_000000_rusbeldoor_yii2General_platform cannot be reverted.\n";

        return false;
    }
    */
}
