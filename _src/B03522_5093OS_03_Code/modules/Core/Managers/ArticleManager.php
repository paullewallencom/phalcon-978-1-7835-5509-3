<?php
namespace App\Core\Managers;

use \App\Core\Models\Article;

class ArticleManager extends BaseManager
{
    public function find($parameters = null)
    {
        return Article::find($parameters);
    }

    /**
     * Create a new article
     *
     * @param  array                           $data
     * @return string|\App\Core\Models\Article
     */
    public function create($data)
    {
        $article = new Article();
        $article->setArticleShortTitle($data['article_short_title']);
        $article->setArticleLongTitle($data['article_long_title']);
        $article->setArticleDescription($data['article_description']);
        $article->setArticleSlug($data['article_slug']);
        $article->setIsPublished(0);
        $article->setCreatedAt(new \Phalcon\Db\RawValue('NOW()'));

        if (false === $article->create()) {
            foreach ($article->getMessages() as $message) {
                $error[] = (string) $message;
            }

            throw new \Exception(json_encode($error));

        }

        return $article;
    }

    /**
     * Update an existing article
     *
     * @param  number     $id
     * @param  array      $data
     * @throws \Exception
     * @return unknown
     */
    public function update($id, $data)
    {
        $article = Article::findFirstById($id);

        if (!$article) {
            throw new \Exception('Article not found', 404);
        }

        $article->setArticleShortTitle($data['article_short_title']);
        $article->setUpdatedAt(new \Phalcon\Db\RawValue('NOW()'));

        if (false === $article->update()) {
            foreach ($article->getMessages() as $message) {
                $error[] = (string) $message;
            }

            throw new \Exception(json_encode($error));

        }

        return $article;
    }

    /**
     * Delete articles
     *
     * @param  number     $id
     * @throws \Exception
     * @return boolean
     */
    public function delete($id)
    {
        $article = Article::findFirstById($id);

        if (!$article) {
            throw new \Exception('Article not found', 404);
        }

        if (false === $article->delete()) {
            foreach ($article->getMessages() as $message) {
                $error[] = (string) $message;
            }

            throw new \Exception(json_encode($error));
        }

        return true;
    }

}
