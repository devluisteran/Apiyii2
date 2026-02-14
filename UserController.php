<?php

namespace app\modules\api\controllers;

use yii\rest\Controller;
use yii\httpclient\Client;
use Yii;

class UserController extends Controller
{
public function behaviors()
{
    $behaviors = parent::behaviors();

    $behaviors['contentNegotiator']['formats'] = [
        'application/json' => \yii\web\Response::FORMAT_JSON,
    ];

    return $behaviors;
}
    public function actionIndex()
    {
        $client = new Client();

        try {
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl('https://jsonplaceholder.typicode.com/users')
                ->setOptions(['timeout' => 5])
                ->send();

            if (!$response->isOk) {
                Yii::$app->response->statusCode = 500;
                return ['error' => 'API externa respondió con error'];
            }

            return [];

        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
            return ['error' => 'No se pudo conectar con la API externa'];
        }
    }
}
