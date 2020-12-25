<?php
namespace App\Core\Managers;

use App\Core\Models\Article;
use App\Core\Models\ArticleTranslation;
use App\Core\Models\ArticleCategoryArticle;
use App\Core\Models\ArticleHashtagArticle;
use App\Core\Models\Category;
use App\Core\Models\CategoryTranslation;
use App\Core\Models\Hashtag;
use App\Core\Models\User;

use App\Core\Models\Mongo\ArticleLog;

use App\Core\Forms\ArticleForm;

class ArticleManager extends BaseManager
{
    /**
     * Default data when storing or updating an object
     * @var array
     */
    private $default_data = array(
        'article_user_id' => 1,
        'article_is_published' => 0,
        'translations' => array(
            'en' => array(
                'article_translation_short_title' => 'Short title',
                'article_translation_long_title' => 'Long title',
                'article_translation_description' => 'Description',
                'article_translation_slug' => '',
                'article_translation_lang' => 'en',
            ),
        ),
        'categories' => array(),
        'hashtags' => array()
    );

    /**
     * Get form
     * @param  object                      $entity
     * @param  array                       $options
     * @return \App\Core\Forms\ArticleForm
     */
    public function getForm($entity = null, $options = null)
    {
        return new ArticleForm($entity, $options);
    }

    /**
     * Find records
     * @param  array|string                       $parameters
     * @return multitype:\App\Core\Models\Article
     */
    public function find($parameters = null)
    {
        if (isset($parameters['bind']['article_translation_slug'])) {
            $translation = ArticleTranslation::findFirst($parameters);
            if ($translation->count() !== 1) {
                return [$translation->getArticle()->toArray()];
            } else {
                throw new \Exception('Article not found', 404);
            }
        } elseif (isset($parameters['bind']['category_translation_slug'])) {
            $category_translation = CategoryTranslation::findFirst($parameters);
            if ($category_translation->count() !== 1) {
                return $category_translation->getCategory()->getArticles();
            } else {
                throw new \Exception('Article not found', 404);
            }
        } else {
            return Article::find($parameters);
        }
    }

    /**
     * Find first record
     * @param  array|string             $parameters
     * @return \App\Core\Models\Article
     */
    public function findFirst($parameters = null)
    {
        return Article::findFirst($parameters);
    }

    /**
     * Find first record by id
     * @param number $id
     */
    public function findFirstById($id)
    {
        return Article::findFirstById($id);
    }

    /**
     * Create a new article
     *
     * @param  array                           $data
     * @param  string                          $language
     * @return string|\App\Core\Models\Article
     */
    public function create($input_data)
    {
        $data = $this->prepareData($input_data);

        $article = new Article();
        $article->setArticleIsPublished($data['article_is_published']);

        $articleTranslations = array();

        foreach ($data['translations'] as $lang => $translation) {
            $tmp = new ArticleTranslation();
            $tmp->assign($translation);
            array_push($articleTranslations, $tmp);
        }

        if ($data['categories']) {
            $article->categories = Category::find([
                "id IN (".$data['categories'].")",
            ])->filter(function ($category) {
                return $category;
            });
        }

        if ($data['hashtags']) {
            $article->hashtags = Hashtag::find([
                "id IN (".$data['hashtags'].")",
            ])->filter(function ($hashtag) {
                return $hashtag;
            });
        }

        $user = User::findFirstById((int) $data['article_user_id']);

        if (!$user) {
            throw new \Exception('User not found', 404);
        }

        $article->setArticleUserId($data['article_user_id']);

        $article->translations = $articleTranslations;

        $result = $this->save($article, 'create');

        return $result;
    }

    /**
     * Update an existing article
     *
     * @param  number     $id
     * @param  array      $input_data
     * @throws \Exception
     * @return unknown
     */
    public function update($input_data)
    {
        $article = Article::findFirstById($input_data['id']);

        if (!$article) {
            throw new \Exception('Article not found', 404);
        }

        $data = $this->prepareData($input_data);

        $article->setArticleIsPublished($data['article_is_published']);
        $article->setArticleUpdatedAt(new \Phalcon\Db\RawValue('NOW()'));

        foreach ($data['translations'] as $lang => $translation) {
            $article->getTranslations()->filter(function ($t) use ($lang, $translation) {
                if ($t->getArticleTranslationLang() == $lang) {
                    $t->assign($translation);
                    $t->update();
                }
            });
        }

        $results = ArticleCategoryArticle::findByArticleId($input_data['id']);

        if ($results) {
            $results->delete();
        }

        if ($data['categories']) {
            $article->categories = Category::find([
                "id IN (".$data['categories'].")",
            ])->filter(function ($category) {
                return $category;
            });
        }

        $results = ArticleHashtagArticle::findByArticleId($input_data['id']);

        if ($results) {
            $results->delete();
        }

        if ($data['hashtags']) {
            $article->hashtags = Hashtag::find([
                "id IN (".$data['hashtags'].")",
            ])->filter(function ($hashtag) {
                return $hashtag;
            });
        }

        $user = User::findFirstById((int) $data['article_user_id']);

        if (!$user) {
            throw new \Exception('User not found', 404);
        }

        $article->setArticleUserId($data['article_user_id']);

        $result = $this->save($article, 'update');

        return $result;
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

    /**
     * Preparing data (avoid code repetition)
     *
     * @param  array $input_data
     * @return array
     */
    private function prepareData($input_data)
    {
        $data = array_merge($this->default_data, $input_data);

        if (!is_array($data['categories'])) {
            $data['categories'] = $data['categories'] != '' ? array_map('trim', explode(',', $data['categories'])) : null;
        } else {
            $data['categories'] = implode(',', $data['categories']);
        }

        if (!is_array($data['hashtags'])) {
            $data['hashtags'] = $data['hashtags'] != '' ? array_map('trim', explode(',', $data['hashtags'])) : null;
        } else {
            $data['hashtags'] = implode(',', $data['hashtags']);
        }

        return $data;
    }

    /**
     * Simple paginator for native array
     *
     * @param  array                                       $data
     * @param  integer                                     $limit
     * @param  integer                                     $page
     * @return \Phalcon\Paginator\Adapter\stdClass|boolean
     */
    protected function paginate($data, $limit, $page)
    {
        $paginator = new \Phalcon\Paginator\Adapter\NativeArray(
            array(
                "data" => $data,
                "limit"=> $show,
                "page" => $page
            )
        );

        $items = $paginator->getPaginate();

        if ($items->total_items > 0) {
            return $items;
        }

        return false;
    }

    protected function esNormalize($article)
    {
        $body = json_decode(json_encode($article->toArray(), JSON_NUMERIC_CHECK), true);

        $body['article_created_at'] = str_replace(' ', 'T', $body['article_created_at']);

        if ($body['article_updated_at'] != '') {
            $body['article_updated_at'] = str_replace(' ', 'T', $body['article_updated_at']);
        } else {
            $body['article_updated_at'] = $body['article_created_at'];
        }

        return $body;
    }

    /**
     * Index data into ElasticSearch
     *
     * @param  \App\Core\Models\Article $article
     * @return boolean
     */
    public function esIndex($article)
    {
        $elastic_manager = $this->getDI()->get('elastic');

        $params          = array();
        $params['index'] = 'learningphalcon';
        $params['type']  = 'article';
        $params['id']    = 'article-' . $article->getId();
        $params['body']  = $this->esNormalize($article);

        $elastic_manager->index($params);

        return true;
    }

    /**
     * Delete a post from ES
     * @param number $article_id
     */
    public function esdelete($article_id)
    {
        $elastic_manager = $this->getDI()->get('elastic');

        $params['index'] = 'learningphalcon';
        $params['type']  = 'article';
        $params['id']  = 'article-'.(int)$article_id;

        try {
            $elastic_manager->delete($params);
        } catch (\Exception $e) {

        }
    }

    /**
     * Log article visits in MongoDB
     *
     * @param number $article_id
     * @param \Phalcon\Http\Request $request
     */
    public function mongoLog($article_id, \Phalcon\Http\Request $request)
    {
        $log = new ArticleLog();
        $log->log($article_id, $request);
    }

    /**
     * Count visits
     *
     * @param number $article_id
     * @param boolean $unique
     * @return number
     */
    public function countVisits($article_id, $unique = false)
    {
        $alog = new ArticleLog();
        return $alog->countVisits($article_id, $unique);
    }
}
