<?php

namespace App\Core\Models;

class ArticleHashtagArticle extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $article_id;

    /**
     *
     * @var integer
     */
    protected $hashtag_id;

    /**
     * Method to set the value of field article_id
     *
     * @param  integer $article_id
     * @return $this
     */
    public function setArticleId($article_id)
    {
        $this->article_id = $article_id;

        return $this;
    }

    /**
     * Method to set the value of field hashtag_id
     *
     * @param  integer $hashtag_id
     * @return $this
     */
    public function setHashtagId($hashtag_id)
    {
        $this->hashtag_id = $hashtag_id;

        return $this;
    }

    /**
     * Returns the value of field article_id
     *
     * @return integer
     */
    public function getArticleId()
    {
        return $this->article_id;
    }

    /**
     * Returns the value of field hashtag_id
     *
     * @return integer
     */
    public function getHashtagId()
    {
        return $this->hashtag_id;
    }

    public function getSource()
    {
        return 'article_hashtag_article';
    }

    /**
     * @return ArticleHashtagArticle[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return ArticleHashtagArticle
     */
    public static function findFirst($parameters = array())
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'article_id' => 'article_id',
            'hashtag_id' => 'hashtag_id',
        );
    }

    public function initialize()
    {
        $this->belongsTo('hashtag_id', 'App\Core\Models\Hashtag', 'id',
            array('alias' => 'hashtag')
        );

        $this->belongsTo('article_id', 'App\Core\Models\Article', 'id',
            array('alias' => 'article')
        );
    }
}
