<?php

use yii\db\Migration;

/**
 * Class m190905_145734_deleteTableProfesion
 */
class m190905_145734_deleteTableProfesion extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {        
        $this->dropForeignKey('fk_profesion','destinatario');
        $this->dropColumn('destinatario', 'profesionid');  
        $this->delete('profesion');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190905_145734_deleteTableProfesion cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190905_145734_deleteTableProfesion cannot be reverted.\n";

        return false;
    }
    */
}
