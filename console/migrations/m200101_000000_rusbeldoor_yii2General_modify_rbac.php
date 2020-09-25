<?php

use yii\db\Migration;

/**
 * Class m200101_000000_rusbeldoor_yii2General_modify_rbac
 */
class m200101_000000_rusbeldoor_yii2General_modify_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('auth_assignment', 'user_id', $this->integer(11)->unsigned()->notNull());
        $this->renameColumn('auth_assignment', 'created_at', 'datetime_create');
        $this->alterColumn('auth_assignment', 'datetime_create', $this->datetime()->notNull());

        $this->renameColumn('auth_item', 'created_at', 'datetime_create');
        $this->renameColumn('auth_item', 'updated_at', 'datetime_update');
        $this->alterColumn('auth_item', 'datetime_create', $this->datetime()->notNull());
        $this->alterColumn('auth_item', 'datetime_update', $this->datetime()->notNull());

        $this->renameColumn('auth_rule', 'created_at', 'datetime_create');
        $this->renameColumn('auth_rule', 'updated_at', 'datetime_update');
        $this->alterColumn('auth_rule', 'datetime_create', $this->datetime()->notNull());
        $this->alterColumn('auth_rule', 'datetime_update', $this->datetime()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200101_000000_rusbeldoor_yii2General_modify_rbac cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200101_000000_rusbeldoor_yii2General_modify_rbac cannot be reverted.\n";

        return false;
    }
    */
}
