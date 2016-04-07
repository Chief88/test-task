<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\User */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="user-form">

	<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

	<?= $form->errorSummary($model); ?>

	<?= $form->field($model, 'username') ?>
	<?= $form->field($model, 'email') ?>
	<?= $form->field($model, 'password')->passwordInput() ?>
<!--	--><?//= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
//		'captchaAction' => '/user/captcha',
//		'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
//	]) ?>

	<div class="form-group">
		<?= Html::submitButton('Создать', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
	</div>
	<?php ActiveForm::end(); ?>

</div>
