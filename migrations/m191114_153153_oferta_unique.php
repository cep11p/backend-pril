<?php

use yii\db\Migration;

/**
 * Class m191114_153153_oferta_unique
 */
class m191114_153153_oferta_unique extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('area_entrenamiento', 'ofertaid', $this->integer(11)->notNull()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191114_153153_oferta_unique cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191114_153153_oferta_unique cannot be reverted.\n";

        return false;
    }
    */
}
