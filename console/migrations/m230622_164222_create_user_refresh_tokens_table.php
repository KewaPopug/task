<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_refresh_tokens}}`.
 */
class m230622_164222_create_user_refresh_tokens_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_refresh_tokens}}', [
            'user_refresh_tokenID' => $this->primaryKey(),
            'urf_userID' => $this->integer()->notNull(),
            'urf_token' => $this->string(1000)->notNull(),
            'urf_ip' => $this->string(50)->notNull(),
            'urf_user_agent' => $this->string(1000)->notNull(),
            'urf_created' => $this->date()->notNull(),
        ], $tableOptions);

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-post-author_id',
            'user_refresh_tokens',
            'urf_userID',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%user_refresh_tokens}}');
    }
}
