<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \common\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['email-confirm', 'token' => $user->email_confirm_token]);
?>

<?= Yii::t('app', 'Здравствуйте')?>, <?= Html::encode($user->username) ?>!

<?= Yii::t('app', 'Для подтверждения адреса пройдите по ссылке')?>:

<?= Html::a(Html::encode($confirmLink), $confirmLink) ?>

<?= Yii::t('app', 'Если Вы не регистрировались на на нашем сайте, то просто удалите это письмо.'); ?>