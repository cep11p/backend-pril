<?php

use yii\db\Migration;

/**
 * Handles adding conocimientos_basicos to table `destinatario`.
 */
class m181018_135441_add_conocimientos_basicos_column_to_destinatario_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('destinatario', 'conocimientos_basicos', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('destinatario', 'conocimientos_basicos');
    }
}
