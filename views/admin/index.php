<?php

use yii\helpers\Html;
use yii\grid\GridView;
$content = Yii::$app->getModule('content')->model('Content');

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var \app\modules\content\models\Content $content
 */

$this->title = Yii::t('content', 'Content');
if($parent->isRoot()){
    $this->params['breadcrumbs'][] = $this->title;
}else{
    $this->params['breadcrumbs'][] = ['label'=>$this->title,'url'=>\yii\helpers\Url::to(array('parent'=>null))];
    foreach($parent->parents()->all() as $ancestor){
        if(!$ancestor->isRoot()){
            $this->params['breadcrumbs'][] = ['label'=>$ancestor->header,'url'=>\yii\helpers\Url::to(array('parent'=>$ancestor->id))];
        }
    }
    $this->params['breadcrumbs'][] = $parent->header;
}
?>
<div class="content-index">

    <?php echo \yii\widgets\Breadcrumbs::widget(['links'=>$this->params['breadcrumbs']])?>
    <h1><?= Html::encode($parent->header) ?></h1>
    <p>
        <?= Html::a(Yii::t('content', 'Create {modelClass}', [
            'modelClass' => 'content',
        ]), \yii\helpers\Url::toRoute(['create','parent'=>$parent->id]), ['class' => 'btn btn-success']) ?>
    </p>



    <div id="content-list">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                [
                    'attribute'=>'header',
                    'format'=>'raw',
                    'value'=>function($data){
                            return Html::a($data->header,\yii\helpers\Url::toRoute(['/content/default/show','code'=>$data->code]));
                        },
                ],
                'create_time',
                [
                    'attribute'=>'parent',
                    'value'=>function($data){
                            return $data->parent->header;
                        }
                ],
                'visible',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {add}',
                    'buttons' => [
                        'view' => function($url,$model){
                                return Html::a('<span class="glyphicon glyphicon-eye-open "></span>',
                                    \yii\helpers\Url::toRoute(['/content/default/show','code'=>$model->code])
                                );
                            },
                        'add' => function($url, $model, $key){
                                return Html::a('<span class="glyphicon glyphicon-plus"></span>',
                                    \yii\helpers\Url::toRoute(['/content/admin/update','parent'=>$model->id])
                                );

                            }
                    ]
                ],
            ],
        ]); ?>
    </div>

</div>
