<?php

namespace api\controllers;

use yii\web\Response;
use common\models\Portfolio;
use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;

/**
 * Portfolio controller
 */
class PortfolioController extends ActiveController
{
    public $modelClass = Portfolio::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index'] ['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }
    public function prepareDataProvider()
    {
        $searchModel = new \common\models\PortfolioSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
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
}
