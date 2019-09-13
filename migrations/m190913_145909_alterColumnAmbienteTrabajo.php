<?php

use yii\db\Migration;

/**
 * Class m190913_145909_alterColumnAmbienteTrabajo
 */
class m190913_145909_alterColumnAmbienteTrabajo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('ambiente_trabajo', 'legajo', $this->string(45)->unique()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190913_145909_alterColumnAmbienteTrabajo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190913_145909_alterColumnAmbienteTrabajo cannot be reverted.\n";

        return false;
    }
    */
}
