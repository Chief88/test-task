<?php
use yii\grid\GridView;
use common\models\Operation;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */

$this->title = Yii::$app->name . ' | ' . Yii::t('app', 'Отправленные средства');
$this->params['breadcrumbs'][] = Yii::t('app', 'Отправленные средства');
?>
<div class="user-signup">
	<h1><?= Yii::t('app', 'История списаний'); ?></h1>

	<div class="row">
		<div class="col-md-12">

			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],

					[
						'attribute' => 'type',
						'value' => function ($model, $index, $dataColumn) {
							/** @var $model \common\models\Operation */
							switch ($model->type) {
								case Operation::TYPE_ENROLL:
									$label = '<span class="label label-primary">' . $model->getTypeName() . '</span>';
									break;
								default:
									$label = '<span class="label label-default">' . $model->getTypeName() . '</span>';
							}
							return $label;
						},
						'format' => 'raw',
					],
					[
						'attribute' => 'sender.username',
						'label' => Yii::t('app', 'Отправитель')
					],
					[
						'attribute' => 'recipient.username',
						'label' => Yii::t('app', 'Получатель')
					],
					[
						'attribute' => 'amount',
						'value' => function ($model, $index, $dataColumn) {
							/** @var $model Operation */
							return $model->amount . ' <span class="glyphicon glyphicon-rub" aria-hidden="true"></span>';
						},
						'format' => 'raw',
					],
					[
						'attribute' => 'created_at',
						'label' => 'Дата',
						'value' => function ($model, $index, $dataColumn) {
							/** @var $model Operation */
							return date('Y.m.d H:i:s', $model->created_at);
						},
					],
					[
						'attribute' => 'balance_sender',
						'label' => Yii::t('app', 'Баланс после операции'),
						'value' => function ($model, $index, $dataColumn) {
							/** @var $model Operation */
							return $model->balance_sender . ' <span class="glyphicon glyphicon-rub" aria-hidden="true"></span>';
						},
						'format' => 'raw',
					],

				],
			]); ?>

		</div>
	</div>
</div>