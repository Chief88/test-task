<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\User */

$this->title = Yii::$app->name . ' | ' . Yii::t('app', 'Создание пользователя');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Создание');
?>
<div class="user-create">

	<h1><?= Yii::t('app', 'Создание пользователя'); ?></h1>

	<?= $this->render('_createForm', [
		'model' => $model,
	]) ?>

</div>
