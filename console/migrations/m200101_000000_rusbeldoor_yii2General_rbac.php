<?php

use yii\db\Migration;

/**
 * Class m200101_000000_rusbeldoor_yii2General_rbac
 */
class m200101_000000_rusbeldoor_yii2General_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица правил
        if (Yii::$app->db->schema->getTableSchema('auth_rule', true)) { $this->dropTable('auth_rule'); }
        $this->createTable('auth_rule', [
            'id' => $this->primaryKey(11)->unsigned(),
            'name' => $this->string(96)->notNull(),
            'data' => $this->binary(65536)->defaultValue(null),
        ]);
        $this->createIndex('unique-name', 'auth_rule', 'name', true);

        // Таблица ролей, операций
        if (Yii::$app->db->schema->getTableSchema('auth_item', true)) { $this->dropTable('auth_item'); }
        $this->createTable('auth_item', [
            'id' => $this->primaryKey(11)->unsigned(),
            'name' => $this->string(96)->notNull(),
            'type' => $this->tinyInteger(1)->unsigned()->notNull(),
            'description' => $this->string(192)->defaultValue(null),
            'rule_name' => $this->string(64)->defaultValue(null),
            'data' => $this->binary(65536)->defaultValue(null),
            'created_at' => $this->integer(11)->defaultValue(null),
            'updated_at' => $this->integer(11)->defaultValue(null),
        ]);
        $this->createIndex('unique-name', 'auth_item', 'name', true);
        $this->addForeignKey('fk-auth_item-auth_rule', 'auth_item', 'rule_name', 'auth_rule', 'name');

        // Таблица соответсвия ролей и операций
        if (Yii::$app->db->schema->getTableSchema('auth_item_child', true)) { $this->dropTable('auth_item_child'); }
        $this->createTable('auth_item_child', [
            'id' => $this->primaryKey(11)->unsigned(),
            'parent' => $this->string(96)->notNull(),
            'child' => $this->string(96)->notNull(),
        ]);
        $this->createIndex('unique-parent-child', 'auth_item_child', ['parent', 'child'], true);
        $this->createIndex('index-child', 'auth_item_child', 'child');

        // Таюлица соответсвия ролей, операций и пользователей
        if (Yii::$app->db->schema->getTableSchema('auth_assignment', true)) { $this->dropTable('auth_assignment'); }
        $this->createTable('auth_assignment', [
            'id' => $this->primaryKey(11)->unsigned(),
            'item_name' => $this->string(96)->notNull(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
        ]);
        $this->createIndex('unique-item_name-user_id', 'auth_assignment', ['item_name', 'user_id'], true);
        $this->addForeignKey('fk-auth_assignment-auth_item', 'auth_assignment', 'item_name', 'auth_item', 'name');

        // Создание ролей, операций
        $this->insert('auth_item', ['id' => 1, 'name' => 'administrator', 'type' => 1, 'description' => 'Адинистратора']);
        $this->insert('auth_item', ['id' => 1000, 'name' => 'rusbeldoor_rbac', 'type' => 2, 'description' => 'Rusbeldoor, Роли и операции']);
        $this->insert('auth_item_child', ['parent' => 'administrator', 'child' => 'rusbeldoor_rbac']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200101_000000_rusbeldoor_yii2General_rbac cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200101_000000_rusbeldoor_yii2General_rbac cannot be reverted.\n";

        return false;
    }
    */
}
