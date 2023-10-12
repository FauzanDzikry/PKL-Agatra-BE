<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Portfolio */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Portfolios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="portfolio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'title',
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
            [
                'attribute' => 'client_id',
                'value' => function($model){
                    return $model->client->name;
                }
            ],
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
            'created_at',
            'updated_at',
        ],
    ]) ?>
    <p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
