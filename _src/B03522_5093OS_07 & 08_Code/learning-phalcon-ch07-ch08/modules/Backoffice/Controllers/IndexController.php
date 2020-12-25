<?php
namespace App\Backoffice\Controllers;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $total_articles   = $this->getDI()->get('core_article_manager')->find()->count();
        $total_users      = $this->getDI()->get('core_user_manager')->find()->count();
        $total_categories = $this->getDI()->get('core_category_manager')->find()->count();
        $total_hashtags   = $this->getDI()->get('core_hashtag_manager')->find()->count();

        $this->view->setVar('dashboard', [
            'total_articles'   => $total_articles,
            'total_users'      => $total_users,
            'total_categories' => $total_categories,
            'total_hashtags'   => $total_hashtags,
        ]);
    }
}
