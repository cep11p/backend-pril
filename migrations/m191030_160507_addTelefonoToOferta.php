<?php

use yii\db\Migration;

/**
 * Class m191030_160507_addTelefonoToOferta
 */
class m191030_160507_addTelefonoToOferta extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('oferta', 'telefono', $this->string(50)->defaultValue(''));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191030_160507_addTelefonoToOferta cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191030_160507_addTelefonoToOferta cannot be reverted.\n";

        return false;
    }
    */
}
