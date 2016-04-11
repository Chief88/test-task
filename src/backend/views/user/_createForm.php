<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model \backend\models\form\SignupForm */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="user-form">

	<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

	<?= $form->errorSummary($model); ?>

	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'username') ?>
			<?= $form->field($model, 'email') ?>
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'password')->passwordInput() ?>
			<?= $form->field($model, 'role')->dropDownList(User::getRoleArray()); ?>
		</div>
	</div>

	<div class="form-group">
		<?= Html::submitButton('Создать', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
	</div>
	<?php ActiveForm::end(); ?>

</div>
