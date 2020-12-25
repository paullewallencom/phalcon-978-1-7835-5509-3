<?php
namespace App\Frontend\Controllers;

class ArticleController extends BaseController
{
    public function listAction()
    {
        $page = $this->request->getQuery('p', 'int', 1);

        try {
            $records = $this->apiGet('articles',['p' => $page, 'limit' => 2]);

            $this->view->records = $records;
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }
    }

    public function readAction($slug)
    {
        try {
            $records     = $this->apiGet("articles/slug/$slug");
            $manager     = $this->getDI()->get('core_article_manager');
            $total_views = $manager->countVisits($records['items'][0]['id']);

            $manager->mongoLog($records['items'][0]['id'], $this->request);
            $this->view->records = $records;
            $this->view->total_views = $total_views;
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }
    }

    public function categoriesAction($slug)
    {
        $this->view->pick('article/list');

        try {
            $records = $this->apiGet("articles/category/$slug");

            $this->view->records = $records;
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }
    }
}
