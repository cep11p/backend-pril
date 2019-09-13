<?php

use yii\db\Migration;

/**
 * Class m190912_161304_alterColumnDestinatario
 */
class m190912_161304_alterColumnDestinatario extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('destinatario', 'fecha_ingreso', $this->date()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190912_161304_alterColumnDestinatario cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190912_161304_alterColumnDestinatario cannot be reverted.\n";

        return false;
    }
    */
}
