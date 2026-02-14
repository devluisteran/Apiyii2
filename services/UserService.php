<?php
namespace app\services;

use yii\base\Exception;
use yii\httpclient\Client;

class UserService
{
    public function getUsersFromApi()
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('https://jsonplaceholder.typicode.com/users')
            ->send();

        if (!$response->isOk) {
            throw new Exception('La API respondió con código ' . $response->statusCode);
        }

        $users = $response->data; 
        return $users;
    }

    public function filterBizEmails($users)
    {
        return array_values(array_filter($users, function($user) {
            return isset($user['email']) && substr($user['email'], -4) === '.biz';
        }));
    }
}
