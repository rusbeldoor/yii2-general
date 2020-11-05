<?php

use yii\db\Migration;

/**
 * Class m200103_000000_rusbeldoor_yii2General_rbac
 */
class m200103_000000_rusbeldoor_yii2General_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица правил
        $this->createTable('auth_rule', [
            'id' => $this->primaryKey(11)->unsigned(),
            'name' => $this->string(96)->notNull(),
            'data' => $this->binary(65536)->defaultValue(null),
        ]);
        $this->createIndex('unique-name', 'auth_rule', 'name', true);

        // Таблица ролей, операций
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
        $this->createTable('auth_item_child', [
            'id' => $this->primaryKey(11)->unsigned(),
            'parent' => $this->string(96)->notNull(),
            'child' => $this->string(96)->notNull(),
        ]);
        $this->createIndex('unique-parent-child', 'auth_item_child', ['parent', 'child'], true);
        $this->createIndex('index-child', 'auth_item_child', 'child');

        // Таблица соответсвия ролей, операций и пользователей
        $this->createTable('auth_assignment', [
            'id' => $this->primaryKey(11)->unsigned(),
            'item_name' => $this->string(96)->notNull(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'created_at' => $this->integer(11)->defaultValue(null),
        ]);
        //$this->createIndex('unique-item_name-user_id', 'auth_assignment', ['item_name', 'user_id'], true);
        $this->addForeignKey('fk-auth_assignment-auth_item', 'auth_assignment', 'item_name', 'auth_item', 'name');
        $this->addForeignKey('fk-auth_assignment-user_id', 'auth_assignment', 'user_id', 'user', 'id'); // Закомментировать, если таблица users лежит не в той же БД или имеет другое название

        // Создание ролей, операций
        $this->insert('auth_item', ['id' => 1, 'name' => 'administrator', 'type' => 1, 'description' => 'Адинистратор']);
        $this->insert('auth_item', ['id' => 1000, 'name' => 'rusbeldoor-rbac', 'type' => 2, 'description' => 'Rusbeldoor, Роли и операции']);
        $this->insert('auth_item_child', ['parent' => 'administrator', 'child' => 'rusbeldoor-rbac']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200103_000000_rusbeldoor_yii2General_rbac cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200103_000000_rusbeldoor_yii2General_rbac cannot be reverted.\n";

        return false;
    }
    */
}
