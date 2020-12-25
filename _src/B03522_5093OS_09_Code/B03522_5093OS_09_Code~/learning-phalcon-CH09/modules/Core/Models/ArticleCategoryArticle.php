<?php

namespace App\Core\Models;

class ArticleCategoryArticle extends Base
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
    protected $category_id;

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
     * Method to set the value of field category_id
     *
     * @param  integer $category_id
     * @return $this
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;

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
     * Returns the value of field category_id
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function getSource()
    {
        return 'article_category_article';
    }

    /**
     * @return ArticleCategoryArticle[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return ArticleCategoryArticle
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
            'category_id' => 'category_id',
        );
    }

    public function initialize()
    {
        $this->belongsTo('category_id', 'App\Core\Models\Category', 'id',
            array('alias' => 'category')
        );

        $this->belongsTo('article_id', 'App\Core\Models\Article', 'id',
            array('alias' => 'article')
        );
    }
}
