<?php
namespace App\Backoffice\Controllers;

class ArticleController extends BaseController
{
    public function indexAction()
    {
        return $this->dispatcher->forward(['action' => 'list']);
    }

    public function listAction()
    {
        $article_manager = $this->getDI()->get('core_article_manager');

        $articles = $article_manager->find([
            'order' => 'created_at DESC',
            'cache' => [
                'key' => 'articles',
                'lifetime' => 3600
            ]
        ]);

        $this->view->articles = $articles;
    }

    public function createAction()
    {
        $this->view->disable();

        $article_manager = $this->getDI()->get('core_article_manager');

        try {
            $article = $article_manager->create([
                'article_short_title' => 'Test article short title 5',
                'article_long_title' => 'Test article long title 5',
                'article_description' => 'Test article description 5',
                'article_slug' => 'test-article-short-title-5'
            ]);
            echo $article->getArticleShortTitle(), " was created.";
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function updateAction($id)
    {
        $this->view->disable();

        $article_manager = $this->getDI()->get('core_article_manager');

        try {
            $article = $article_manager->update($id, [
                'article_short_title' => 'Modified article 1'
            ]);
            echo $article->getId(), " was updated.";
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteAction($id)
    {
        $this->view->disable();

        $article_manager = $this->getDI()->get('core_article_manager');

        try {
            $article_manager->delete($id);
            echo "Article was deleted.";
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}
