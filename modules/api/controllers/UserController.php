<?php

namespace app\modules\api\controllers;

use yii\rest\Controller;
use yii\httpclient\Client;
use Yii;


use app\services\UserService;

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
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    try {
        $service = new UserService();
        $users = $service->getUsersFromApi();
        $filtered = $service->filterBizEmails($users);
        return ['success' => true, 'data' => $filtered];
    } catch (\Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}
                
}
