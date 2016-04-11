<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = Yii::$app->name . ' | ' . Yii::t('app', 'Личный кабинет');
$this->params['breadcrumbs'][] = Yii::t('app', 'Личный кабинет');
$user = Yii::$app->user->identity;
?>
<div class="user-signup">
	<h1><?= $user->username; ?></h1>

	<div class="row">
		<div class="col-md-6">
			<p><strong>E-mail</strong>: <?= $user->email; ?></p>
			<p>
				<strong><?= Yii::t('app', 'Баланс'); ?></strong>: <span class="badge"><?= $user->balance; ?> <span
						class="glyphicon glyphicon-rub" aria-hidden="true"></span></span>
			</p>
		</div>

		<div class="col-md-3">
			<h3><?= Yii::t('app', 'История операций') ?>:</h3>

		</div>
	</div>
</div>