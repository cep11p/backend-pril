<?php

use yii\db\Migration;

/**
 * Class m191025_145723_ambiente_trabajo_atributos_por_defecto
 */
class m191025_145723_ambiente_trabajo_atributos_por_defecto extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = "ambiente_trabajo";
        $this->alterColumn($table, 'telefono1', $this->string(25)->defaultValue(''));
        $this->alterColumn($table, 'telefono2', $this->string(25)->defaultValue(''));
        $this->alterColumn($table, 'telefono3', $this->string(25)->defaultValue(''));
        $this->alterColumn($table, 'fax', $this->string(25)->defaultValue(''));
        $this->alterColumn($table, 'email', $this->string(50)->defaultValue(''));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191025_145723_ambiente_trabajo_atributos_por_defecto cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191025_145723_ambiente_trabajo_atributos_por_defecto cannot be reverted.\n";

        return false;
    }
    */
}
