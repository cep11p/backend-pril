<?php

namespace app\modules\backend\controllers\api;

/**
* This is the class for REST controller "ProfesionController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ProfesionController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Profesion';
}
