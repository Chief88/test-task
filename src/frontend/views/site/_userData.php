<?php
use common\widgets\TransferModal\TransferModalWidget;

/**
 * @var \common\models\User $user
 */
?>

<h3><?= Yii::t('app', 'Ваши данные'); ?>:</h3>
<p><strong>Nicname</strong>: <?= $user->username; ?></p>
<p><strong>E-mail</strong>: <?= $user->email; ?></p>
<p>
	<strong><?= Yii::t('app', 'Баланс'); ?></strong>: <span class="badge"><?= $user->balance; ?> <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></span>
</p>

<?= TransferModalWidget::widget(['user' => $user]); ?>