<?php

use yii\db\Migration;

/**
 * Class m181031_145035_altercolumn_legajo_column_destinatario_table
 */
class m181031_145035_altercolumn_legajo_column_destinatario_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("destinatario", "legajo", "varchar (50) NOT NULL unique");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181031_145035_altercolumn_legajo_column_destinatario_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181031_145035_altercolumn_legajo_column_destinatario_table cannot be reverted.\n";

        return false;
    }
    */
}
