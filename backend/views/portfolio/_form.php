<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Image;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Portfolio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="portfolio-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => true])
     ?>
    <?= $form->field($model, 'client_id')->widget(select2::classname(),[
        'data' => $client,
        'options' => ['placeholder' => 'Pilih Client'],
        'theme' => select2::THEME_BOOTSTRAP,
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?> 
    <?php if (!$model->isNewRecord): ?>
        <?php
        if (!empty($model->image)){
                 
             $img = Html::img(Yii::$app->params['hostImage'].'/'.$modelImage->image, ['width' => '200px']);

                }
        ?>
    
    <?= $form->field($modelImage, 'image')->widget(kartik\file\FileInput::class,[
            'options' => [
                'accept' => 'image/*',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'showUpload' => false,
                'showCancel' => false,
                'previewFileType' => 'image',
                'initialPreview' =>  Html::img(Yii::$app->params['hostImage'].'/'.$modelImage->image, ['width' => '200px']),
                'initialCaption' => $modelImage->image,
                'uploadAsync'=> true,
            ]
         ])?>
        <?php else : ?>
            <?= $form->field($modelImage, 'image')->widget(kartik\file\FileInput::class, [
            'options' => [
                'accept' => 'image/*',
                'multiple' => false
            ],
            'pluginOptions' => [
                'showUpload' => false,
            ]
        ]); ?>
    <?php endif; ?>
  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
