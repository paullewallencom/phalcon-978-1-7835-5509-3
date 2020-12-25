<?php
namespace App\Frontend\Controllers;

class IndexController extends BaseController
{
    public function indexAction()
    {
        return $this->dispatcher->forward([
            'controller' => 'article',
            'action' => 'list'
        ]);
    }
}
