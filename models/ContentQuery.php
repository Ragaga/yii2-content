<?php

namespace ragaga\yii2\content\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use Yii;

class ContentQuery extends \yii\db\ActiveQuery
{

    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}
