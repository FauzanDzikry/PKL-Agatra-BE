<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'client', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            //'image_id',
            [
                'attribute' => 'image',
                'format' => 'html',    
                'value' => function ($data) {
                    return Html::img($data->imageTable['image_url'],
                        ['width' => '500px']);
                },
            ],
            //'path',
           //'image_url:url',
            //'client_id',
            
            [
                'attribute' => 'created_by',
                'value' => function($data){
                    return $data->createdBy->username;
                }
            ],

            [
                'attribute' => 'updated_by',
                'value' => function($data){
                    return $data->updatedBy->username;
                }
            ],
            
            [
                'attribute' => 'deleted_by',
                'value' => function($data){
                    return $data->deletedBy->username;
                }
            ],
            'created_at',
            'updated_at',
            'deleted_at',

        ],
    ]) ?>
        <p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>


</div>
