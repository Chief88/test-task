<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use kartik\date\DatePicker;
use kartik\field\FieldRange;

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
				'attribute' => 'bills.balance',
				'value' => function ($model, $index, $dataColumn) {
					/** @var $model \common\models\User */
					return $model->balance . ' <span class="glyphicon glyphicon-rub" aria-hidden="true"></span>';
				},
				'format' => 'raw',
				'filter' => FieldRange::widget([
					'model' => $searchModel,
					'attribute1' => 'balance_from',
					'attribute2' => 'balance_to',
					'options1' => ['placeholder' => Yii::t('app', 'От')],
					'options2' => ['placeholder' => Yii::t('app', 'До')],
					'template' => '{widget}{error}',
					'separator' => '-',
				]),
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
				'filter' => Html::activeDropDownList($searchModel, 'role',
					$searchModel->getRoleArray(),
					[
						'prompt' => Yii::t('app', '-- Любая --'),
						'class' => 'form-control',
					])
			],
			[
				'attribute' => 'created_at',
				'value' => function ($model, $index, $dataColumn) {
					/** @var $model \common\models\User */
					return date('Y.m.d H:i:s', $model->created_at);
				},
				'filter' => DatePicker::widget([
					'model' => $searchModel,
					'attribute' => 'date_from',
					'attribute2' => 'date_to',
					'type' => DatePicker::TYPE_RANGE,
					'separator' => '-',
					'pluginOptions' => ['format' => 'yyyy-mm-dd']
				]),
			],
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
				'class' => 'yii\grid\ActionColumn',
				'template'=> '<div style="min-width: 80px">{update}&nbsp;{enrollMoney}&nbsp;{transferMoney}</div>',
				'buttons' => [
					'enrollMoney' => function ($url, $model, $key) {
						return $this->render('_enrollModal', ['model' => $model]);
					},
					'transferMoney' => function ($url, $model, $key) {
						return $this->render('_transferModal', ['model' => $model]);
					},
				]
			]
		],
	]); ?>

</div>
