<?php

use yii\db\Migration;

/**
 * Class m200101_000000_rusbeldoor_yii2General_user
 */
class m200101_000000_rusbeldoor_yii2General_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица пользователей
        if (Yii::$app->db->schema->getTableSchema('user', true)) { $this->dropTable('user'); }
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'verification_token' => $this->string()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200101_000000_rusbeldoor_yii2General_user cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200101_000000_rusbeldoor_yii2General_user cannot be reverted.\n";

        return false;
    }
    */
}
