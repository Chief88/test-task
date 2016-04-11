<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $user \common\models\User */
/** @var $password string */

$confirmLink = Yii::$app->params['frontendAbsoluteUrl'] . Yii::$app->urlManager->createUrl(['email-confirm', 'token' => $user->email_confirm_token]);
?>

<p><?= Yii::t('app', 'Здравствуйте') ?>, <?= Html::encode($user->username) ?>!</p>
<p>
	<?= Yii::t('app', 'Для подтверждения адреса пройдите по ссылке') ?>:
	<?= Html::a(Html::encode($confirmLink), $confirmLink) ?>
</p>
<p><?= Yii::t('app', 'Пароль для входа в систему'); ?>: <?= $password; ?></p>
<p><?= Yii::t('app', 'Если Вы не регистрировались на на нашем сайте, то просто удалите это письмо.'); ?></p>
