<?php
namespace App\Api\Controllers;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $this->view->disable();
        echo 'OK index';
    }

    public function articlesAction()
    {
        $this->view->disable();
        echo 'OK articles';
    }
}
