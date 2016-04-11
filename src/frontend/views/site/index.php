<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\form\SignupForm */
/* @var $dataProvider \yii\data\ArrayDataProvider */

$this->title = Yii::$app->name . ' | ' . Yii::t('app', 'Главная');
?>
<div class="user-signup">
	<h1><?= Yii::t('app', 'Добро пожаловать'); ?>!</h1>

	<div class="row">
		<div class="col-md-5">

			<?php if (Yii::$app->user->isGuest) {
				echo $this->render('_signupForm', [
					'model' => $model,
				]);
			} else {
				echo $this->render('_userData', [
					'user' => Yii::$app->user->identity,
				]);
			} ?>
		</div>

		<div class="col-md-7">
			<h3><?= Yii::t('app', 'Наши пользователи') ?>:</h3>
			<?= ListView::widget([
				'dataProvider' => $dataProvider,
				'itemView' => '_userListItem',
				'itemOptions' => [
					'class' => 'list-group-item',
					'tag' => 'li'
				],
				'options' => [
					'class' => 'list-group',
					'tag' => 'ul'
				],
				'summary' => false,
			]); ?>

		</div>
	</div>
</div>