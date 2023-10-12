<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PortfolioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Deleted Portfolios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portfolio-index">

    <p>
        <?= Html::a('Back', ['/portfolio'], ['class' => 'btn btn-primary']) ?>
    </p>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
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

            'description',

            'created_at',

            [
                'format'=>'raw',
                'value' => function($model){
                return
                    Html::a('<i class="bi bi-eye-fill"></i>', ['view','id'=>$model->id], ['title' => 'view','class'=>'btn btn-primary']).' '.
                    Html::a('<i class="bi bi-arrow-clockwise"></i>', ['restore', 'id' => $model->id], ['class' => 'btn btn-success']).' '.
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
    ]); 
    ?>


</div>
