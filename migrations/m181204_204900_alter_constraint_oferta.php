<?php

use yii\db\Migration;

/**
 * Class m181204_204900_alter_constraint_oferta
 */
class m181204_204900_alter_constraint_oferta extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = "oferta";
        $this->dropForeignKey("fk_oferta_ambiente_trabajo1", $table);
        $this->addForeignKey("fk_oferta_ambiente_trabajo", $table, "ambiente_trabajoid", "ambiente_trabajo", "id", "CASCADE", "NO ACTION");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181204_204900_alter_constraint_oferta cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_204900_alter_constraint_oferta cannot be reverted.\n";

        return false;
    }
    */
}
