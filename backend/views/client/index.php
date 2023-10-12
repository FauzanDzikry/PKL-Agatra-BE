<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Image;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use Cloudinary\Transformation\Format;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Client', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="bi bi-trash me-1"></i> Trash', ['/deleted-client'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             
            'name',
            [
                'attribute' => 'image_id',
                'format' => 'html',    
                'value' => function ($data) {
                    return Html::img($data->imageTable['image_url'],
                        ['width' => '50px']);
                },
            ],

            'description',

            'created_at',

            [
                'format'=>'raw',
                'value' => function($model){
                return
                    Html::a('<i class="bi bi-eye-fill"></i>', ['view','id'=>$model->id], ['title' => 'view','class'=>'btn btn-primary']).' '.
                    Html::a('<i class="bi bi-pencil-fill"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-success']).' '.
                    Html::a('<i class="bi bi-trash"></i>', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]);
                }
            ],
        ],
    ]); ?>

    <?php LinkPager::widget([
        'pagination'=>$dataProvider->pagination,
    ]); ?>

</div>
