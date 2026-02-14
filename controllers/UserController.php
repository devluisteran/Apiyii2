<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\httpclient\Client;

use app\services\UserService;

class UserController extends Controller
{
    public function actionIndex()
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    try {
        $service = new UserService();
        $users = $service->getUsersFromApi();
        $filtered = $service->filterBizEmails($users);
        return ['success' => true, 'data' => []];
    } catch (\Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
    
        
}
