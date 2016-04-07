<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $user \common\models\User */
/** @var $password string */
/** @var $isPasswordUpdate boolean */
/** @var $isEmailUpdate boolean */

$confirmLink = Yii::$app->params['frontendAbsoluteUrl'] . Yii::$app->urlManager->createUrl(['email-confirm', 'token' => $user->email_confirm_token]);
?>

	<p><?= Yii::t('app', 'Здравствуйте') ?>, <?= Html::encode($user->username) ?>!</p>
	<p><?= Yii::t('app', 'Данные вашего аккаунта были обновлены администратором') ?></p>

<?php if ($isEmailUpdate): { ?>
	<p>
		<?= Yii::t('app', 'Ваш e-mail был изменен, для подтверждения адреса пройдите по ссылке') ?>:
		<?= Html::a(Html::encode($confirmLink), $confirmLink) ?>
	</p>
<?php }endif; ?>

<?php if ($isPasswordUpdate): { ?>
	<p><?= Yii::t('app', 'Новый пароль'); ?>: <?= $password; ?></p>
<?php }endif; ?>