<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `app\modules\user\models\User`.
 */
class UserSearch extends User
{
	public $date_from;
	public $date_to;
	public $balance_from;
	public $balance_to;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'role', 'created_at', 'updated_at', 'status'], 'integer'],
			[['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
			[['balance_from', 'balance_to', 'bills.balance'], 'number'],
			[['bills.balance', 'created_at', 'updated_at', 'username', 'email'], 'safe'],
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
		return array_merge(parent::attributes(), ['bills.balance']);
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
		$query = User::find()->alias('t');
		$query->joinWith('bills');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
		]);

		$addSortAttributes = [
			'bills.balance',
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

		$query->andFilterWhere([
			'id' => $this->id,
			't.role' => $this->role,
			'status' => $this->status,
		]);

		$query->andFilterWhere(['like', 'username', $this->username])
			->andFilterWhere(['like', 'auth_key', $this->auth_key])
			->andFilterWhere(['like', 'email_confirm_token', $this->email_confirm_token])
			->andFilterWhere(['like', 'password_hash', $this->password_hash])
			->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
			->andFilterWhere(['like', 'email', $this->email])
			->andFilterWhere(['>=', 't.created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
			->andFilterWhere(['<=', 't.created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null])
			->andFilterWhere(['>=', 'bills.balance', $this->balance_from ? $this->balance_from : null])
			->andFilterWhere(['<=', 'bills.balance', $this->balance_to ? $this->balance_to : null]);

		return $dataProvider;
	}
}
