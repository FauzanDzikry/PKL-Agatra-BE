<?php

namespace api\controllers;

use yii\web\Response;
use common\models\Client;
use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;

/**
 * Client controller
 */
class ClientController extends ActiveController
{
    public $modelClass = 'common\models\Client';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'OPTIONS'],
                'Access-Control-Expose-Headers' => ['X-Pagination-Total-Count', 'X-Pagination-Page-Count', 'X-Pagination-Current-Page', 'X-Pagination-Per-Page'],
                // 'Access-Control-Allow-Credentials' => true,
            ],
        ];
        $behaviors['authenticator']['except'] = ['options'];

        // $behaviors['authenticator']['only'] = ['create', 'update', 'delete'];
        // $behaviors['authenticator']['authMethods'] = [
        //     HttpBearerAuth::class
        // ];
        return $behaviors;
        }
    
    public function actionDelete($id){
        $model = Client::find()
        ->where(['id' => $id, 'is_deleted' => 1])
        ->one();
    if ($model){
        $model->is_deleted = 0;
        $model->save(false);
        return $this->responseAngularSuccess200('Data deleted');
    } else {
        return $this->responseAngularEror200(404, 'data not found');
    }
    }
}
