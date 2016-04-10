<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\User */

$this->title = Yii::$app->name . ' | ' . Yii::t('app', 'Редактирование') . ' | ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактирование');
?>
<div class="user-update">

	<h1><?= Yii::t('app', 'Редактирование пользователя'); ?>: <?= $model->username; ?></h1>

	<?= $this->render('_updateForm', [
		'model' => $model,
	]) ?>

</div>
