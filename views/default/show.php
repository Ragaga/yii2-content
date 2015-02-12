<?php
/**
 * @var \app\modules\content\models\Content $model
 * @var yii\web\View $this
 */
$this->title = $model->title ? : $model->header;
$this->registerMetaTag(['name'=>'description','content'=>$model->description]);
foreach($model->parents()->all() as $ancestor){
    if(!$ancestor->isRoot()){
        $this->params['breadcrumbs'][] = ['label'=>$ancestor->header,'url'=>\yii\helpers\Url::to(array('code'=>$ancestor->code))];
    }
}
$this->params['breadcrumbs'][] = $model->header;
?>
<?php echo \yii\widgets\Breadcrumbs::widget(['links'=>$this->params['breadcrumbs']])?>

<div class="Content-default-show">
    <h1><?= $model->header ?></h1>
    <?= $model->text ?>
</div>
