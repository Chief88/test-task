<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider*/

$this->title = Yii::$app->name . ' | ' . Yii::t('app', 'Главная');
?>
<div class="user-signup">
    <h1><?= Yii::t('app', 'Добро пожаловать'); ?>!</h1>

    <div class="row">
        <div class="col-md-12">
            <h3><?= Yii::t('app', 'Наши пользователи')?>:</h3>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_userListItem',
                'summary' => false,
            ]); ?>
        </div>
    </div>
</div>