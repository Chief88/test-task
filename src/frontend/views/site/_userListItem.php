<?php
/**
 * @var \common\models\User $model
 */
?>
	<span class="badge"><?= $model->balance; ?> <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></span>
<?= $model->username; ?> (<?= $model->email; ?>)