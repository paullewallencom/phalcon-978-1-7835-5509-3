<?php
namespace App\Core\Controllers;

class BaseController extends \Phalcon\Mvc\Controller
{
    public function apiGet($uri, $params = [])
    {
        $config   = $this->getDI()->get('config')->toArray();
        $uri      = $config['apiUrl'].$uri;
        $curl     = new \Phalcon\Http\Client\Provider\Curl();
        $response = $curl->get($uri, $params, ["APIKEY:".$config['apiKeys'][0]]);

        if ($response->header->statusCode != 200) {
            throw new \Exception('API error: '.$response->header->status);
        }

        return json_decode($response->body, true);
    }
}
