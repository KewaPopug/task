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
        $this->addColumn('{{%profile}}', 'surname', $this->string()->notNull());
        $this->addColumn('{{%profile}}', 'firstname', $this->string()->notNull());
        $this->addColumn('{{%profile}}', 'patronymic', $this->string()->defaultValue(null));
        $this->addColumn('{{%profile}}', 'individual_identification_number', $this->bigInteger()->notNull());
        $this->addColumn('{{%profile}}', 'date_born', $this->date()->notNull());
        $this->addColumn('{{%profile}}', 'photo_url', $this->string()->notNull());

    }

    public function down()
    {
        $this->dropColumn('{{%profile}}', 'surname');
        $this->dropColumn('{{%profile}}', 'firstname');
        $this->dropColumn('{{%profile}}', 'patronymic');
        $this->dropColumn('{{%profile}}', 'individual_identification_number');
        $this->dropColumn('{{%profile}}', 'date_born');
        $this->dropColumn('{{%profile}}', 'photo_url');
    }
}
