<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */
/* @var $form yii\widgets\ActiveForm */

/*** Var dump ***/
//echo '<pre>'; var_dump($model->getRoleArray()); echo '</pre>';
//die('die');
/*** End var dump ***/

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->dropDownList($model->getRoleArray()); ?>
    <?= $form->field($model, 'status')->dropDownList($model->getStatusesArray()); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord
            ? Yii::t('app', 'Create')
            : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
