<?php
namespace App\Backoffice\Controllers;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $this->view->disable();
        die('ok');
    }
}
