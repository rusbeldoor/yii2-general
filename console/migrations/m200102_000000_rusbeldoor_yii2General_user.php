<?php

use yii\db\Migration;

/**
 * Class m200102_000000_rusbeldoor_yii2General_user
 */
class m200102_000000_rusbeldoor_yii2General_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица пользователей
        $this->createTable('user', [
            'id' => $this->primaryKey(11)->unsigned(),
            'username' => $this->string(32)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(96)->notNull(),
            'password_reset_token' => $this->string(96)->unique(),
            'email' => $this->string(128)->notNull()->unique(),
            'status' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(10),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'verification_token' => $this->string(96)->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200102_000000_rusbeldoor_yii2General_user cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200102_000000_rusbeldoor_yii2General_user cannot be reverted.\n";

        return false;
    }
    */
}
