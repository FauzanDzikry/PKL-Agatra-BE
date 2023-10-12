<?php

namespace api\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'OPTIONS'],
                'Access-Control-Expose-Headers' => ['X-Pagination-Total-Count', 'X-Pagination-Page-Count', 'X-Pagination-Current-Page', 'X-Pagination-Per-Page'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Allow-Origin' => ['*'],
            ],
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        Yii::$app->response->statusCode = 200;
        return [
            'status' => true,
            'error' => 200,
            'message' => "route not found"
        ];
    }

    public function actionError()
    {
        Yii::$app->response->statusCode = 200;
        return [
            'status' => false,
            'error' => 404,
            'message' => "route not found"
        ];
    }

    public function humanSize($Bytes)
    {
        $Type = array("", "kilo", "mega", "giga", "tera", "peta", "exa", "zetta", "yotta");
        $Index = 0;
        while ($Bytes >= 1024) {
            $Bytes /= 1024;
            $Index++;
        }
        return ("" . $Bytes . " " . $Type[$Index] . "bytes");
    }

    public function actionHealth()
    {
        $memory = $this->humanSize(memory_get_usage());
        $diskfree = $this->humanSize(disk_free_space("/"));
        $usage = sys_getloadavg();
        $data = [
            'memoryusage' => $memory,
            'diskfree' => $diskfree,
            'Cpu' => $usage
        ];
        return $this->responseItem($data, 'status Active');
    }

    // public function actionInsert()
    // {
    //     $prov = Provinsi::find()->all();

    //     foreach ($prov as $key => $value) {
    //         $newProv = new Wilayah();
    //         $newProv->nama = $value->nama;
    //         $newProv->slug = $value->slug;
    //         $newProv->kode_prov = $value->kode;
    //         $newProv->save();
    //     }

    //     return $this->responseAngularSuccess200(["status"=> "finish"]);
    // }
}
