<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;

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
			[
				'attribute' => 'status',
				'value' => function ($model, $index, $dataColumn) {
					/** @var $model \common\models\User */
					switch($model->status){
						case User::STATUS_BLOCKED:
							$label = '<span class="label label-default">' . $model->getStatusName() . '</span>';
							break;
						case User::STATUS_WAIT:
							$label = '<span class="label label-warning">' . $model->getStatusName() . '</span>';
							break;
						default:
							$label = '<span class="label label-success">' . $model->getStatusName() . '</span>';
					}
					return $label;
				},
				'format' => 'raw',
				'filter' => Html::activeDropDownList($searchModel, 'status',
					$searchModel->getStatusesArray(),
					[
						'prompt' => Yii::t('app', '-- Любой --'),
						'class' => 'form-control',
					])
			],
			[
				'attribute' => 'role',
				'value' => function ($model, $index, $dataColumn) {
					/** @var $model \common\models\User */
					switch($model->role){
						case User::ROLE_ADMIN:
							$label = '<span class="label label-primary">' . $model->getRoleName() . '</span>';
							break;
						default:
							$label = '<span class="label label-default">' . $model->getRoleName() . '</span>';
					}
					return $label;
				},
				'format' => 'raw',
			],
			[
				'attribute' => 'created_at',
				'value' => function ($model, $index, $dataColumn) {
					/** @var $model \common\models\User */
					return date('Y.m.d H:i:s', $model->created_at);
				},
			],

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

</div>
