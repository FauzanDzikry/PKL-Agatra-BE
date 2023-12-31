<?php

namespace backend\controllers;

use Yii;
use common\models\Client;
use yii\web\Controller;
use common\models\Image;
use yii\helpers\VarDumper;
use yii\filters\VerbFilter;
use app\models\DeletedClientSearch;
use yii\web\NotFoundHttpException;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

/**
 * DeletedClientController implements the CRUD actions for Client model.
 */
class DeletedClientController extends Controller
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
                    'class' => VerbFilter::class,
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
        $searchModel = new DeletedClientSearch();
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
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $modelImage = $this->getDataImage($id);
        $newModel = new Client;
        $imageId[] = $newModel['image_id'];

        $searchImage = Client::find($imageId)->where(['image_id' => $model->image_id])->all();
        $getCount = Client::find($imageId)->where(['image_id' => $model->image_id])->count();

        $config = Configuration::instance();
        $config->cloud->cloudName = 'daobmhs10';
        $config->cloud->apiKey = '149968649183817';
        $config->cloud->apiSecret = '4QplUFKd4mD4Hyk4heRRFOtJGp4';
        $config->url->secure = true;

        if((!$model->image_id = $searchImage && $getCount >= 2)){
            (new UploadApi())->destroy($model->path);
            $model->delete();
            $modelImage->delete();
            Yii::$app->session->setFlash('success', 'Client deleted successfully');
            return $this->redirect(['index']);

        }
        else{
            $model->delete();
            Yii::$app->session->setFlash('success', 'Client deleted successfully');
            return $this->redirect(['index']);
        }

        // (new UploadApi())->destroy($model->path);

        // $model->delete();
        // Yii::$app->session->setFlash('success', 'Client deleted successfully');

        // return $this->redirect(['index']);
    }

    public function actionRestore($id)
    {
        $model = $this->findModel($id);
        $model->is_deleted = 0;
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

    protected function getDataImage($id){
        $modelImage = new Image();
        $model = $this->findModel($id);
        $imageId = $modelImage['id'];
        if(($dataImage = Image::find($imageId)->where(['id' => $model->image_id])->one())){
            return $dataImage;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
