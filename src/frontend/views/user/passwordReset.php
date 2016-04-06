<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\form\PasswordResetForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::$app->name . ' | ' . Yii::t('app', 'Смена пароля');
$this->params['breadcrumbs'][] = Yii::t('app', 'Смена пароля');
?>
<div class="user-user-reset-password">
	<h1><?= Yii::t('app', 'Смена пароля'); ?></h1>

	<p>Введите новый пароль:</p>

	<div class="row">
		<div class="col-lg-5">
			<?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

			<?= $form->field($model, 'password')->passwordInput() ?>

			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>