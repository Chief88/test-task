<?php

namespace common\widgets\TransferModal;

use Yii;
use yii\base\Widget;
use common\models\form\TransferForm;

/**
 * Class TransferModalWidget
 * @package common\widgets\TransferModal
 */
class TransferModalWidget extends Widget
{

	public $view = 'main';
	public $user;

	public function run()
	{
		$transfer = new TransferForm();
		$transfer->sender_id = $this->user->id;
		return $this->render('@common/widgets/TransferModal/views/' . $this->view, [
			'transfer' => $transfer,
			'user' => $this->user,
		]);
	}

}

?>
