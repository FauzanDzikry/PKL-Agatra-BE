<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Image;
use common\models\Client;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use Cloudinary\Transformation\Format;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PortfolioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Portfolio';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portfolio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Create Portfolio', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="bi bi-trash me-1"></i> Trash', ['/deleted-portfolio'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            
            [
                'attribute' => 'image_id',
                'format' => 'html',    
                'value' => function ($data) {
                    return Html::img($data->imageTable['image_url'],
                        ['width' => '50px']);
                },
            ],

/*             [
                'attribute' => 'client_id',
                'format' => 'html',
                'value' => function($model){
                    return $model->client->name;
                }
            ], */
            'client.name',

            'description',
            
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
