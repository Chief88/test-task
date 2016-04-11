<?php
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<h3><?= Yii::t('app', 'Регистрация'); ?>:</h3>

<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
	'captchaAction' => '/user/captcha',
	'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
]) ?>
<div class="form-group">
	<?= Html::submitButton(Yii::t('app', 'Зарегистрироваться'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
</div>
<?php ActiveForm::end(); ?>