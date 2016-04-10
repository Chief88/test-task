<?php
use backend\models\form\EnrollForm;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var \common\models\User $model
 */

$enroll = new EnrollForm();
$enroll->recipient_id = $model->id;
?>

<button type="button" class="btn btn-default btn-xs"
        data-toggle="modal"
        data-target="#replenishment-modal-<?= $model->id; ?>"
        title="<?= Yii::t('app', 'Зачислить деньги') ?>">
	<span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
</button>

<!-- Modal -->
<div class="modal fade"
     id="replenishment-modal-<?= $model->id; ?>"
     tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					<?= Yii::t('app', 'Зачисление средств') ?>
				</h4>
			</div>

			<div class="modal-body">
				<?php $form = ActiveForm::begin([
					'id' => 'enroll-form-' . $model->id,
					'action' => Url::toRoute(['/operation/enroll']),
					'enableAjaxValidation' => true,
					'enableClientValidation' => true,
					'validateOnSubmit' => true,
				]); ?>

				<div class="form-group">
					<label class="control-label"><?= $enroll->getAttributeLabel('recipient_id'); ?></label>
					<p class="form-control-static"><?= $model->username; ?></p>
				</div>
				<?= $form->field($enroll, 'amount')->textInput(); ?>
				<?= $form->field($enroll, 'recipient_id')->hiddenInput()->label(false); ?>

				<div class="form-group">
					<?= Html::submitButton(Yii::t('app', 'Зачислить'), [
						'class' => 'btn btn-primary',
						'name' => 'contact-button'
					]) ?>
				</div>

				<?php ActiveForm::end(); ?>
			</div>

		</div>
	</div>
</div>