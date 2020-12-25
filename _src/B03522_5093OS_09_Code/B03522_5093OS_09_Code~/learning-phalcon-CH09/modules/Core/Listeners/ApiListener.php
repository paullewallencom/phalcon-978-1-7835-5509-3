<?php
namespace App\Core\Listeners;

class ApiListener extends \Phalcon\Mvc\User\Plugin
{
    public function beforeExecuteRoute($event, $dispatcher)
    {
        $hasValidKey = $this->checkForValidApiKey();
        $ipRateLimit = $this->checkIpRateLimit();

        if (false === $hasValidKey || false === $ipRateLimit) {
            return false;
        }

        if (false === $this->resourceWithToken()) {
            return false;
        }
    }

    private function checkForValidApiKey()
    {
        $apiKey = $this->request->getHeader('APIKEY');

        if (!in_array($apiKey, $this->config->apiKeys->toArray())) {
            $this->response->setStatusCode(403, 'Forbidden');
            $this->response->sendHeaders();
            $this->response->send();
            $this->view->disable();

            return false;
        }

        return true;
    }

    private function checkIpRateLimit()
    {
        $ip   = $this->request->getClientAddress();
        $time = time();
        $key  = $ip.':'.$time;

        $redis   = $this->getDI()->get('redis');
        $current = $redis->get($key);

        if ($current != null && $current > 5) {
            $this->response->setStatusCode(429, 'Too Many Requests');
            $this->response->sendHeaders();
            $this->response->send();
            $this->view->disable();

            return false;
        } else {
            $redis->multi();
            $redis->incr($key, 1);
            $redis->expire($key, 5);
            $redis->exec();
        }

        return true;
    }

    private function resourceWithToken()
    {
        if (in_array($this->dispatcher->getActionName(), ['update', 'delete', 'create'])) {
            if ($this->request->getHeader('TOKEN') != 'mySecretToken') {
                $this->response->setStatusCode(405, 'Method Not Allowed');
                $this->response->sendHeaders();
                $this->response->send();
                $this->view->disable();

                return false;
            }

            return true;
        }
    }
}
