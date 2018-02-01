<?php

use yii\db\Migration;

/**
 * Handles the creation of table `file_record`.
 */
class m180201_202600_create_file_record_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%file_record}}', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string(255),
            'user_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
        ]);

        // add foreign key for table `user`
        $this->addForeignKey(
            'FK_file_record-user-id',
            '{{%file_record}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%file_record}}');
    }
}
