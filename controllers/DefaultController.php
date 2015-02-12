<?php

namespace ragaga\yii2\content\controllers;

use yii\web\Controller;
use yii\web\HttpException;

class DefaultController extends Controller
{
    public function actionShow($code)
    {
        $contentModel= \Yii::$app->getModule("content")->model("Content");
        $model = $contentModel->find()->where('code=:code',['code'=>$code])->one();
        if(!$model){
            throw new HttpException('404',Yii::t('content','Page not found'));
        }
        return $this->render('show',['model'=>$model]);
    }
}
