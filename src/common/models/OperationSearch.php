<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Operation;

/**
 * OperationSearch represents the model behind the search form about `common\models\Operation`.
 */
class OperationSearch extends Operation
{
	public $currentUserId;
	public $date_from;
	public $date_to;
	public $amount_from;
	public $amount_to;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'sender_id', 'recipient_id', 'owner', 'type', 'created_at', 'updated_at'], 'integer'],
			[['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
			[['amount_from', 'amount_to', 'amount', 'balance_sender', 'balance_recipient'], 'number'],
			[['owner.username', 'sender.username', 'recipient.username'], 'safe']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * @inheritdoc
	 */
	public function attributes() {
		// add related fields to searchable attributes
		return array_merge(parent::attributes(), ['owner.username', 'sender.username', 'recipient.username']);
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = Operation::find()->alias('t');
		$query->joinWith('owner');
		$query->joinWith('sender');
		$query->joinWith('recipient');

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
		]);

		$addSortAttributes = [
			'owner.username',
			'sender.username',
			'recipient.username',
		];
		foreach ($addSortAttributes as $addSortAttribute) {
			$dataProvider->sort->attributes[$addSortAttribute] = [
				'asc' => [$addSortAttribute => SORT_ASC],
				'desc' => [$addSortAttribute => SORT_DESC],
			];
		}

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			'id' => $this->id,
			'balance_sender' => $this->balance_sender,
			'balance_recipient' => $this->balance_recipient,
			'type' => $this->type,
		]);

		$query->andFilterWhere(['like', 'owner.username', $this->getAttribute('owner.username')])
			->andFilterWhere(['like', 'sender.username', $this->getAttribute('sender.username')])
			->andFilterWhere(['like', 'recipient.username', $this->getAttribute('recipient.username')])
			->andFilterWhere(['>=', 'amount', $this->amount_from ? $this->amount_from : null])
			->andFilterWhere(['<=', 'amount', $this->amount_to ? $this->amount_to : null])
			->andFilterWhere(['>=', 't.created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
			->andFilterWhere(['<=', 't.created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

		return $dataProvider;
	}
}
