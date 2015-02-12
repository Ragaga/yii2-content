<?php

use yii\helpers\Html;
use moonland\tinymce\TinyMCE;

$content = Yii::$app->getModule('content')->model('Content');

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var \app\modules\content\models\Content $content
 */

$this->title = $model->isNewRecord ? Yii::t('content','Create content') : Yii::t('content','Update content');

$this->params['breadcrumbs'][] = ['label'=>'Content','url'=>\yii\helpers\Url::toRoute('/content/admin',['parent'=>null])];

if($model->isNewRecord){
    $this->params['breadcrumbs'][] = Yii::t('content','Create content');
}else{
    foreach($model->parents()->all() as $ancestor){
        if(!$ancestor->isRoot()){
            $this->params['breadcrumbs'][] = ['label'=>$ancestor->header,'url'=>\yii\helpers\Url::toRoute('/content/admin',['parent'=>$ancestor->id])];
        }
    }
    $this->params['breadcrumbs'][] = Yii::t('content','Update content {header}',['header'=>$model->header]);
}
?>
<div class="content-index">

    <?php echo \yii\widgets\Breadcrumbs::widget(['links'=>$this->params['breadcrumbs']])?>
    <h1><?= $model->isNewRecord ? Yii::t('content','Create content') : Yii::t('content','Update content') ?></h1>
    <div class="content-form">

        <?php $form = \yii\widgets\ActiveForm::begin(); ?>
        <?= $form->field($model, 'header')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'text')->widget(TinyMCE::className()) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'description')->textarea(); ?>

        <?= $form->field($model, 'code')->textInput(['disabled' => 'disabled']) ?>

        <?= $form->field($model, 'url')->textInput(['disabled' => 'disabled']) ?>

        <?= Html::activeLabel($model, 'visible'); ?>
        <?= Html::activeCheckbox($model, 'visible'); ?>
        <?= Html::error($model, 'visible'); ?>

        <div class="form-group">
            <?= Html::submitButton($user->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php \yii\widgets\ActiveForm::end(); ?>

    </div>

</div>
