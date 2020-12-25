<?php
namespace App\Frontend\Controllers;

class BaseController extends \App\Core\Controllers\BaseController
{
    public function afterExecuteRoute()
    {
        $this->view->categories = $this->apiGet('categories');
    }
}
