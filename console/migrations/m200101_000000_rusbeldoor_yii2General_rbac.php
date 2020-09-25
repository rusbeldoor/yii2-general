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
        $this->createTable('auth_rule', [
            'id' => $this->primaryKey(11)->unsigned(),
            'name' => $this->string(64)->notNull(),
            'data' => $this->binary()->default(null),
            'datetime_create' => $this->dateTime()->notNull(),
            'datetime_update' => $this->dateTime()->notNull(),
        ]);
        $this->createIndex('unique-name', 'auth_rule', 'name', true);

        $this->createTable('auth_item', [
            'id' => $this->primaryKey(11)->unsigned(),
            'name' => $this->string(64)->notNull(),
            'type' => $this->tinyint(1)->unsigned()->notNull(),
            'description' => $this->string(255)->default(null),
            'rule_name' => $this->string(64)->default(null),
            'data' => $this->binary()->default(null),
            'datetime_create' => $this->dateTime()->notNull(),
            'datetime_update' => $this->dateTime()->notNull(),
        ]);
        $this->createIndex('unique-name', 'auth_item', 'name', true);
        $this->addForeignKey('fk-auth_item-auth_rule', 'auth_item', 'rule_name', 'auth_rule', 'name');

        $this->createTable('auth_item_child', [
            'id' => $this->primaryKey(11)->unsigned(),
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
        ]);
        $this->createIndex('unique-parent-child', 'auth_item_child', ['parent', 'child'], true);
        $this->createIndex('index-child', 'auth_item_child', 'child');

        $this->createTable('auth_assignment', [
            'id' => $this->primaryKey(11)->unsigned(),
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'datetime_create' => $this->dateTime()->notNull(),
        ]);
        $this->createIndex('unique-item_name-user_id', 'auth_assignment', ['item_name', 'user_id'], true);
        $this->addForeignKey('fk-auth_assignment-auth_item', 'auth_assignment', 'item_name', 'auth_item', 'name');
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
