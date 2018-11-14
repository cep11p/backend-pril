<?php

use yii\db\Migration;

/**
 * Class m181114_151233_insert_plan
 */
class m181114_151233_insert_plan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert("plan", [
            "id"=>1,
            "nombre"=>"Plan A",
            "monto"=>"2000",
            "hora_semanal"=>"10hs"
        ]);
        $this->insert("plan", [
            "id"=>2,
            "nombre"=>"Plan B",
            "monto"=>"3500",
            "hora_semanal"=>"15hs"
        ]);
        $this->insert("plan", [
            "id"=>3,
            "nombre"=>"Plan C",
            "monto"=>"5000",
            "hora_semanal"=>"20hs"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete("plan", [
            "id"=>1,
            "id"=>2,
            "id"=>3
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181114_151233_insert_plan cannot be reverted.\n";

        return false;
    }
    */
}
