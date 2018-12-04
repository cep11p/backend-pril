<?php

use yii\db\Migration;

/**
 * Handles adding observacion to table `area_entrenamiento`.
 */
class m181204_201814_add_observacion_column_to_area_entrenamiento_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('area_entrenamiento', 'obeservacion', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('area_entrenamiento', 'obeservacion');
    }
}
