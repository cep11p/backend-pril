<?php

use yii\db\Migration;

/**
 * Handles adding jornada to table `area_entrenamiento`.
 */
class m181204_201211_add_jornada_column_to_area_entrenamiento_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('area_entrenamiento', 'jornada', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('area_entrenamiento', 'jornada');
    }
}
