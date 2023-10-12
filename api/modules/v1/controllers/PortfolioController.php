<?php

namespace api\modules\v1\controllers;

use common\models\Portfolio;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * Portfolio controller
 */
class PortfolioController extends ActiveController
{
    public $modelClass = Portfolio::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['only'] = ['create', 'update', 'delete'];
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::class
        ];

        return $behaviors;
    }
}