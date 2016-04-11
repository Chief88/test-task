<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\form\LoginForm */

$this->title = Yii::$app->name . ' | ' . Yii::t('app', 'Авторизация');
$this->params['breadcrumbs'][] = Yii::t('app', 'Авторизация');
?>
<div class="user-user-login">
	<h1><?= Yii::t('app', 'Авторизация') ?></h1>

	<div class="row">
		<div class="col-sm-5">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?= Yii::t('app', 'Авторизация') ?></h3>
				</div>

				<div class="panel-body">
					<?php $form = ActiveForm::begin([
						'id' => 'login-form',
						'layout' => 'horizontal',
						'fieldConfig' => [
							'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
							'horizontalCssClasses' => [
								'label' => 'col-sm-2',
								'offset' => 'col-sm-offset-2',
								'wrapper' => 'col-sm-10',
								'error' => '',
								'hint' => '',
							],
						],
					]); ?>
					<?= $form->field($model, 'email') ?>
					<?= $form->field($model, 'password')->passwordInput() ?>
					<?= $form->field($model, 'rememberMe')->checkbox(['class' => ' wwww']); ?>

					<div class="row">
						<div class="col-sm-4 col-sm-offset-2">
							<?= Html::submitButton(Yii::t('app', 'Войти'), [
								'class' => 'btn btn-primary',
								'name' => 'login-button'
							]) ?>
						</div>

						<div class="col-sm-6">
							<?= Html::a(Yii::t('app', 'Забыли пароль?'), ['password-reset-request']) ?>
						</div>
					</div>

					<?php ActiveForm::end(); ?>
				</div>
			</div>

		</div>
	</div>

</div>