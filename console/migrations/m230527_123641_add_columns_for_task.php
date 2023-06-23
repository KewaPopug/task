<?php

use yii\db\Migration;

/**
 * Class m230527_123641_add_columns_for_task
 */
class m230527_123641_add_columns_for_task extends Migration
{

    /**
     * {@inheritdoc}
     */
    /*
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    /*
    public function safeDown()
    {
        echo "m230523_130619_add_columns_for_task cannot be reverted.\n";

        return false;
    }
    */

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%user}}', 'surname', $this->string()->notNull());
        $this->addColumn('{{%user}}', 'firstname', $this->string()->notNull());
        $this->addColumn('{{%user}}', 'patronymic', $this->string()->defaultValue(null));
        $this->addColumn('{{%user}}', 'individual_identification_number', $this->bigInteger()->notNull());
        $this->addColumn('{{%user}}', 'date_born', $this->date()->notNull());
        $this->addColumn('{{%user}}', 'photo_url', $this->string()->notNull());

    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'surname');
        $this->dropColumn('{{%user}}', 'firstname');
        $this->dropColumn('{{%user}}', 'patronymic');
        $this->dropColumn('{{%user}}', 'individual_identification_number');
        $this->dropColumn('{{%user}}', 'date_born');
        $this->dropColumn('{{%user}}', 'photo_url');
    }
}
