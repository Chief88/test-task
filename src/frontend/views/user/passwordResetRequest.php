<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\user\models\PasswordResetRequestForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = Yii::t('app', 'Запрос сброса пароля');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-user-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, укажите адрес электронной почты. Ссылка для сброса пароля будет отправлена на указаный адрес.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email') ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>