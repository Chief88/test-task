<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\User */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="user-form">

	<?php $form = ActiveForm::begin(); ?>
	<?= $form->errorSummary($model); ?>

	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'status')->dropDownList($model->getStatusesArray()); ?>
			<?= $form->field($model, 'role')->dropDownList($model->getRoleArray()); ?>
		</div>

		<div class="col-md-6">
			<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true])
				->label(Yii::t('app', 'Сменить пароль')) ?>
		</div>
	</div>

	<?= $form->field($model, 'username')->hiddenInput()->label(false); ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord
			? Yii::t('app', 'Создать')
			: Yii::t('app', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
