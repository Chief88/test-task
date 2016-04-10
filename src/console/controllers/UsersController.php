<?php
namespace console\controllers;

use common\models\Operation;
use common\models\User;
use yii\console\Controller;
use yii\console\Exception;
use Yii;

class UsersController extends Controller
{
	const COUNT_USERS = 1000;

	public function actionIndex()
	{
		echo 'yii users/create-users' . PHP_EOL;
	}

	public function actionCreateUsers()
	{
		for ($i = 1; $i <= self::COUNT_USERS; $i++) {
			$model = new User();
			$model->username = 'demo_user_' . $i;
			$model->email = 'demo_user_' . $i . '@gmail.com';
			$model->role = User::ROLE_ADMIN;
			$model->generateAuthKey();
			$model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->username);
			$model->status = User::STATUS_ACTIVE;
			$model->save();

			echo 'Users created: ' . $i . '/' . self::COUNT_USERS . '(' . ($i / self::COUNT_USERS) * 100 . '%)' . PHP_EOL;
		}
	}

	public function actionCreateOperations()
	{
		$users = User::find()->all();
		$countUsers = count($users);

		$i = 0;
		foreach ($users as $user) {
			$operation = new Operation();
			$operation->recipient_id = $user->id;
			$operation->amount = rand(50000, 100000);
			$operation->owner_id = 1;
			$operation->type = Operation::TYPE_ENROLL;
			$operation->save();
			$i++;
			echo 'Enrollment in balance: ' . $i . '/' . $countUsers . ' (' . ($i / $countUsers) * 100 . '%)' . PHP_EOL;
		}

		$i = 0;
		foreach ($users as $sender) {
			foreach ($users as $recipient) {
				if ($sender->id == $recipient->id) {
					continue;
				}

				$operation = new Operation();
				$operation->sender_id = $sender->id;
				$operation->recipient_id = $recipient->id;
				$operation->amount = rand(1, 30);
				$operation->owner_id = $sender->id;
				$operation->type = Operation::TYPE_TRANSFER;
				$operation->save();
				$i++;
				echo 'Transfer: ' . $i . '/' . $countUsers * $countUsers . ' (' . ($i / ($countUsers * $countUsers)) * 100 . '%)' . PHP_EOL;
			}
		}
	}

	/**
	 * @param string $username
	 * @throws \yii\console\Exception
	 * @return User the loaded model
	 */
	private function findModel($username)
	{
		if (!$model = User::findOne(['username' => $username])) {
			throw new Exception('User not found');
		}
		return $model;
	}
}