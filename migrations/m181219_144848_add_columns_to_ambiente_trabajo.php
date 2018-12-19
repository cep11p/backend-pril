<?php

use yii\db\Migration;

/**
 * Class m181219_144848_add_columns_to_ambiente_trabajo
 */
class m181219_144848_add_columns_to_ambiente_trabajo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("ambiente_trabajo", "telefono1", $this->string("20"));
        $this->addColumn("ambiente_trabajo", "telefono2", $this->string("20"));
        $this->addColumn("ambiente_trabajo", "telefono3", $this->string("20"));
        
        $this->addColumn("ambiente_trabajo", "email", $this->string("50"));
        $this->addColumn("ambiente_trabajo", "fax", $this->string("20"));
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("ambiente_trabajo", "telefono1");
        $this->dropColumn("ambiente_trabajo", "telefono2");
        $this->dropColumn("ambiente_trabajo", "telefono3");
        $this->dropColumn("ambiente_trabajo", "fax");
        $this->dropColumn("ambiente_trabajo", "email");

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181219_144848_add_columns_to_ambiente_trabajo cannot be reverted.\n";

        return false;
    }
    */
}
