
<?php

namespace ragaga\yii2\content\controllers;

use ragaga\yii2\content\Content;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;

class AdminController extends Controller
{

    public function init()
    {
        // check for admin permission (`tbl_role.can_admin`)
        // note: check for Yii::$app->user first because it doesn't exist in console commands (throws exception)
        if (!empty(\Yii::$app->user) && !\Yii::$app->user->can("admin")) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
        parent::init();
    }

    public function actionIndex($parent = null)
    {

        $model = \Yii::$app->getModule("content")->model("Content");
        $root = $model::find()->roots()->one();
        if(!$root){
            $root = new Content();
            $root->header ="Content root";
            $root->makeRoot();
        }
        if($parent){
            $parent = $model->findOne($parent);
        }
        if(!$parent){
            $parent = $root;
        }
        $dataProvider = new ActiveDataProvider(
            [
                'query'=>$parent->children(),
            ]
        );
        return $this->render('index',['parent'=>$parent,'dataProvider'=>$dataProvider]);
    }

    public function actionUpdate($parent = null, $id = null){
        /**
         * @var $model Content
         */
        $contentModel= \Yii::$app->getModule("content")->model("Content");
        $model = $contentModel->findOne($id);

        if(!$model){
            $model = new $contentModel;
        }
        if(\Yii::$app->request->isPost){
            $model->attributes = \Yii::$app->request->post('Content');
            if($model->isNewRecord){
                $parent = $contentModel->findOne($parent);
                if($model->appendTo($parent)){
                    $this->redirect(Url::to(['id'=>$model->id]));
                }
            }else{
                if($model->save()){
                    $this->refresh();
                }
            }
        }
        return $this->render('update',['model'=>$model]);
    }

    public function actionDelete($id){
        /**
         * @var $model Content
         */
        $contentModel= \Yii::$app->getModule("content")->model("Content");
        $model = $contentModel->findOne($id);
        if($model){
            $model->delete();
        }
        $this->redirect('/content/admin');
    }
}
