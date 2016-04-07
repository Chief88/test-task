<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name . ' | ' . Yii::t('app', 'Пользователи');
$this->params['breadcrumbs'][] = Yii::t('app', 'Пользователи');
?>
<div class="user-index">

	<h1><?= Yii::t('app', 'Пользователи'); ?></h1>

	<p>
		<?= Html::a(Yii::t('app', 'Добавить пользователя'), ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id',
			'username',
			'email:email',
			'status',
			'role',
			'created_at',
			'updated_at',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

</div>
