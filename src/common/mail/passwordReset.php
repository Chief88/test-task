<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['password-reset', 'token' => $user->password_reset_token]);
?>

    Здравствуйте, <?= Html::encode($user->username) ?>!

    Пройдите по ссылке, чтобы сменить пароль:

<?= Html::a(Html::encode($resetLink), $resetLink) ?>