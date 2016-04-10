<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Operation;

/* @var $this yii\web\View */
/* @var $model common\models\Operation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operation-form">

	<?php $form = ActiveForm::begin(); ?>
	<?= $form->errorSummary($model); ?>

	<div class="row">
		<div class="col-md-6">

		</div>

		<div class="col-md-6">
			<?= $form->field($model, 'type')->dropDownList(Operation::getTypeArray()); ?>
		</div>
	</div>
	<?= $form->field($model, 'sender_id')->textInput() ?>

	<?= $form->field($model, 'recipient_id')->textInput() ?>

	<?= $form->field($model, 'amount')->textInput() ?>

	<?= $form->field($model, 'balance_new')->textInput() ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
