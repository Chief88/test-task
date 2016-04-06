<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\form\SignupForm */
/* @var $dataProvider \yii\data\ArrayDataProvider*/

$this->title = Yii::$app->name . ' | ' . Yii::t('app', 'Главная');
?>
<div class="user-signup">
    <h1><?= Yii::t('app', 'Добро пожаловать'); ?>!</h1>

    <div class="row">
        <div class="col-md-5">
            <h3><?= Yii::t('app', 'Регистрация'); ?>:</h3>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'captchaAction' => '/user/captcha',
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]) ?>
            <div class="form-group">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-7">
            <h3><?= Yii::t('app', 'Наши пользователи')?>:</h3>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_userListItem',
                'summary' => false,
            ]); ?>
        </div>
    </div>
</div>