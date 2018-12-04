<?php

use yii\db\Migration;

/**
 * Class m181204_203030_oferta_alter_table
 */
class m181204_203030_oferta_alter_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn("oferta", "tarea");
        $this->dropColumn("oferta", "dia_horario");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181204_203030_oferta_alter_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_203030_oferta_alter_table cannot be reverted.\n";

        return false;
    }
    */
}
