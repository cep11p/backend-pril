<?php

use yii\db\Migration;

/**
 * Class m190903_165231_deleteTableOficio
 */
class m190903_165231_deleteTableOficio extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('oficio');
        $this->dropForeignKey('fk_oficio','destinatario');
        $this->dropColumn('destinatario', 'oficioid');        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190903_165231_deleteTableOficio cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190903_165231_deleteTableOficio cannot be reverted.\n";

        return false;
    }
    */
}
