<?php
use common\models\form\TransferForm;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var \common\models\User $model
 */

$transfer = new TransferForm();
$transfer->sender_id = $model->id;
?>

<button type="button" class="btn btn-default btn-xs"
        data-toggle="modal"
        data-target="#transfer-modal-<?= $model->id; ?>"
        title="<?= Yii::t('app', 'Перевести средства') ?>">
	<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
</button>

<!-- Modal -->
<div class="modal fade"
     id="transfer-modal-<?= $model->id; ?>"
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
					<?= Yii::t('app', 'Перевод стредств') ?>
				</h4>
			</div>

			<div class="modal-body">
				<?php $form = ActiveForm::begin([
					'id' => 'transfer-form-' . $model->id,
					'action' => Url::toRoute(['/operation/transfer']),
					'enableAjaxValidation' => true,
					'enableClientValidation' => true,
					'validateOnSubmit' => true,
					'options' => [
						'class' => 'ajax-validate-form form-personal-account',
					]
				]); ?>

				<div class="form-group">
					<label class="control-label"><?= $transfer->getAttributeLabel('sender_id'); ?></label>
					<p class="form-control-static"><?= $model->username; ?></p>
				</div>
				<?= $form->field($transfer, 'email')->textInput(); ?>
				<?= $form->field($transfer, 'amount')->textInput(); ?>
				<?= $form->field($transfer, 'sender_id')->hiddenInput()->label(false); ?>

				<div class="form-group">
					<?= Html::submitButton(Yii::t('app', 'Перевести'), [
						'class' => 'btn btn-primary',
						'name' => 'contact-button'
					]) ?>
				</div>

				<?php ActiveForm::end(); ?>
			</div>

		</div>
	</div>
</div>