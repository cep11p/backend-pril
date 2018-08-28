<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\Profesion $model
*/

$this->title = Yii::t('models', 'Profesion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Profesions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud profesion-create">

    <h1>
        <?= Yii::t('models', 'Profesion') ?>
        <small>
                        <?= Html::encode($model->id) ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
