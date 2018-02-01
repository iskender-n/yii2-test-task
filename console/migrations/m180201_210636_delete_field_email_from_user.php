<?php

use yii\db\Migration;

/**
 * Class m180201_210636_delete_field_email_from_user
 */
class m180201_210636_delete_field_email_from_user extends Migration
{
    /**
     * Erases Unique and Not Null options from email column
     *
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'email', $this->string());
    }

    /**
     * Turns back to Yii2 initial email column
     *
     *
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'email', $this->string()->notNull()->unique());
    }
}
