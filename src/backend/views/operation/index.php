<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use kartik\field\FieldRange;
use common\models\Operation;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OperationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name . ' | ' . Yii::t('app', 'Операции');
$this->params['breadcrumbs'][] = Yii::t('app', 'Операции');
?>
<div class="operation-index">

	<h1><?= Yii::t('app', 'Операции'); ?></h1>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id',
			[
				'attribute' => 'sender.username',
				'label' => Yii::t('app', 'Отправитель')
			],
			[
				'attribute' => 'recipient.username',
				'label' => Yii::t('app', 'Получатель')
			],
			[
				'attribute' => 'owner.username',
				'label' => Yii::t('app', 'Создатель')
			],
			[
				'attribute' => 'amount',
				'value' => function ($model, $index, $dataColumn) {
					/** @var $model Operation */
					return $model->amount . ' <span class="glyphicon glyphicon-rub" aria-hidden="true"></span>';
				},
				'format' => 'raw',
				'filter' => FieldRange::widget([
					'model' => $searchModel,
					'attribute1' => 'amount_from',
					'attribute2' => 'amount_to',
					'options1' => ['placeholder' => Yii::t('app', 'От')],
					'options2' => ['placeholder' => Yii::t('app', 'До')],
					'template' => '{widget}{error}',
					'separator' => '-',
				]),
			],
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
				'filter' => Html::activeDropDownList($searchModel, 'type',
					$searchModel->getTypeArray(),
					[
						'prompt' => Yii::t('app', '-- Все --'),
						'class' => 'form-control',
					])
			],
			[
				'attribute' => 'created_at',
				'value' => function ($model, $index, $dataColumn) {
					/** @var $model Operation */
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

//			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>
</div>
