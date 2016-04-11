<?php
return [
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'pgsql:host=localhost;dbname=test_task',
			'username' => 'user_test_task',
			'password' => '123456',
			'charset' => 'utf8',
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@common/mail',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport' => true,
		],
	],
	'bootstrap' => ['gii'],
	'modules' => [
		'gii' => 'yii\gii\Module',
	],
];
