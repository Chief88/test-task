<?php

namespace common\models\query;

use common\models\User;
use yii\db\ActiveQuery;
use Yii;

class ManagersQuery extends ActiveQuery
{
    public function overdue($timeout)
    {
        return $this
            ->andWhere(['status' => User::STATUS_WAIT])
            ->andWhere(['<', 'created_at', time() - $timeout]);
    }
}