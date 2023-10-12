<?php

namespace backend\controllers;

use Yii;
use common\models\Client;
use common\models\Image;
use common\models\ClientSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Client();
        $modelImage = new Image();
        $modelImage->scenario = 'create';

        if ($model->load(Yii::$app->request->post())){

            $config = Configuration::instance();
            $config->cloud->cloudName = 'yntks';
            $config->cloud->apiKey = '517749844631813';
            $config->cloud->apiSecret = '7QHVG5eVcx-VxvhHUKQTFSU4ngI';
            $config->url->secure = true;

            $modelImage->image = UploadedFile::getInstance($modelImage, 'image');

            $imageBasename = str_replace(" ", "-", $modelImage->image->basename);
            $imageName = str_replace(" ", "-", $modelImage->image->name);
            $imageHost = Yii::$app->params['hostImage'];
            $image = $modelImage['image'];
            $dataImage = Image::find($image)->where(['image'=> $modelImage->image])->one();

            if (!$modelImage->image->name = $dataImage) {
                if ($model->validate()) {
                   (new UploadApi())->upload($modelImage->image->tempName, [
                        'public_id' => 'client/' . $imageBasename,
                        'quality' => 40,
                        'resource_type' => 'image'
                    ]);


                    $modelImage->image = $imageName;
                    $modelImage->path = 'client/' . $imageBasename;
                    $modelImage->image_url = $imageHost . '/' . $imageName;
                    $modelImage->save();

                    $model->image_id = $modelImage->id;
                    $model->path = 'client/' . $imageBasename;
                    $model->image_url = $imageHost . '/' . $imageName;


                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
            if ($modelImage->image->name = $dataImage) {
                if ($model->validate()) {
                    $model->image_id = $dataImage->id;

                    $model->path = 'client/' . $imageBasename;
                    $model->image_url = $imageHost . '/' . $imageName;

                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelImage' => $modelImage,
            ]);
        }
        }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $newModel = new Client;
        $newModelImage = new Image();
        $modelImage = $this->getDataImage($id);
        $modelImage->scenario = 'update';
        $oldImage = $model->image_id;
        $oldImagePath = $model->path;

        if ($model->load(Yii::$app->request->post())){

            $config = Configuration::instance();
            $config->cloud->cloudName = 'yntks';
            $config->cloud->apiKey = '517749844631813';
            $config->cloud->apiSecret = '7QHVG5eVcx-VxvhHUKQTFSU4ngI';
            $config->url->secure = true;

            $modelImage->image = UploadedFile::getInstance($modelImage, 'image');

            if(!empty($modelImage->image)){

                $imageBasename = str_replace(" ","-", $modelImage->image->basename);
                $imageName = str_replace(" ","-", $modelImage->image->name);
                $imageHost = Yii::$app->params['hostImage'];
                $image = $modelImage['image'];
                $dataImage = Image::find($image)->where(['image' => $modelImage->image])->one();

                $imageId[] = $newModel['image_id'];

                $searchImage_id = Client::find($imageId)->where(['image_id' => $model->image_id])->all();
                $getCount = Client::find($imageId)->where(['image_id' => $model->image_id])->count();

                if (!$modelImage->image->name = $dataImage) {
                    if ($model->validate()){
                        (new UploadApi())->upload($modelImage->image->tempName, [
                            'public_id' => 'client/' . $imageBasename,
                            'quality' => 40,
                            'resource_type' => 'image'
                        ]);
                        
                        if ($model->image_id = $searchImage_id && $getCount >= 2) {
                            $newModelImage->image = $imageName;
                            $newModelImage->path = 'client/' . $imageBasename;
                            $newModelImage->image_url = $imageHost . '/' . $imageName;
                            $newModelImage->save();

                            $model->image_id = $newModelImage->id;
                            $model->path = 'client/' . $imageBasename;
                            $model->image_url = $imageHost . '/' . $imageName;
                         }
                         else{
                            (new UploadApi())->destroy($oldImagePath);
                            $modelImage->image = $imageName;
                            $modelImage->path = 'client/' . $imageBasename;
                            $modelImage->image_url = $imageHost . '/' . $imageName;
                            $modelImage->save();

                            $model->image_id = $modelImage->id;
                            $model->path = 'client/' . $imageBasename;
                            $model->image_url = $imageHost . '/' . $imageName;
                         }

                         if ($model->save()){
                             return $this->redirect(['view', 'id' => $model->id]);
                         }
                    }
                }
                if ($modelImage->image->name = $dataImage) {
                    if ($model->validate()) {
                        $model->image_id = $dataImage->id;

                        $model->path = 'client/' . $imageBasename;
                        $model->image_url = $imageHost . '/' . $imageName;

                        if ($model->save()) {
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    }
                }
            }  
            else {
                $model->image_id = $oldImage;
            }
            $model->save();
            return $this->redirect(['index']);
        }
        else {
            return $this->render('update', [
                'model' => $model,
                'modelImage' => $modelImage
            ]);
        }
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        date_default_timezone_set('Asia/Bangkok');
        $model = $this->findModel($id);
        $model->is_deleted = 1;
        $model->deleted_at = date('Y-m-d H:i:s');
        $model->deleted_by = Yii::$app->user->id; 
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelImage($id)
    {
        if (($modelImage = Image::findOne($id)) !== null) {
            return $modelImage;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function getDataImage($id)
    {
        $modelImage = new Image();
        $model = $this->findModel($id);
        $imageId = $modelImage['id'];
        if (($dataImage = Image::find($imageId)->where(['id' => $model->image_id])->one())) {
            return $dataImage;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
