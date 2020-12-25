<?php

namespace App\Core\Models;

use Phalcon\Utils\Slug;

class ArticleTranslation extends Base
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $article_translation_article_id;

    /**
     *
     * @var string
     */
    protected $article_translation_short_title;

    /**
     *
     * @var string
     */
    protected $article_translation_long_title;

    /**
     *
     * @var string
     */
    protected $article_translation_slug;

    /**
     *
     * @var string
     */
    protected $article_translation_description;

    /**
     *
     * @var string
     */
    protected $article_translation_lang;

    /**
     * Method to set the value of field id
     *
     * @param  integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field article_translation_article_id
     *
     * @param  integer $article_translation_article_id
     * @return $this
     */
    public function setArticleTranslationArticleId($article_translation_article_id)
    {
        $this->article_translation_article_id = $article_translation_article_id;

        return $this;
    }

    /**
     * Method to set the value of field article_translation_short_title
     *
     * @param  string $article_translation_short_title
     * @return $this
     */
    public function setArticleTranslationShortTitle($article_translation_short_title)
    {
        $this->article_translation_short_title = $article_translation_short_title;

        return $this;
    }

    /**
     * Method to set the value of field article_translation_long_title
     *
     * @param  string $article_translation_long_title
     * @return $this
     */
    public function setArticleTranslationLongTitle($article_translation_long_title)
    {
        $this->article_translation_long_title = $article_translation_long_title;

        return $this;
    }

    /**
     * Method to set the value of field article_translation_slug
     *
     * @param  string $article_translation_slug
     * @return $this
     */
    public function setArticleTranslationSlug($article_translation_slug)
    {
        $this->article_translation_slug = $article_translation_slug;

        return $this;
    }

    /**
     * Method to set the value of field article_translation_description
     *
     * @param  string $article_translation_description
     * @return $this
     */
    public function setArticleTranslationDescription($article_translation_description)
    {
        $this->article_translation_description = $article_translation_description;

        return $this;
    }

    /**
     * Method to set the value of field article_translation_lang
     *
     * @param  string $article_translation_lang
     * @return $this
     */
    public function setArticleTranslationLang($article_translation_lang)
    {
        $this->article_translation_lang = $article_translation_lang;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field article_translation_article_id
     *
     * @return integer
     */
    public function getArticleTranslationArticleId()
    {
        return $this->article_translation_article_id;
    }

    /**
     * Returns the value of field article_translation_short_title
     *
     * @return string
     */
    public function getArticleTranslationShortTitle()
    {
        return $this->article_translation_short_title;
    }

    /**
     * Returns the value of field article_translation_long_title
     *
     * @return string
     */
    public function getArticleTranslationLongTitle()
    {
        return $this->article_translation_long_title;
    }

    /**
     * Returns the value of field article_translation_slug
     *
     * @return string
     */
    public function getArticleTranslationSlug()
    {
        return $this->article_translation_slug;
    }

    /**
     * Returns the value of field article_translation_description
     *
     * @return string
     */
    public function getArticleTranslationDescription()
    {
        return $this->article_translation_description;
    }

    /**
     * Returns the value of field article_translation_lang
     *
     * @return string
     */
    public function getArticleTranslationLang()
    {
        return $this->article_translation_lang;
    }

    public function getSource()
    {
        return 'article_translation';
    }

    /**
     * @return ArticleTranslation[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return ArticleTranslation
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
            'id' => 'id',
            'article_translation_article_id' => 'article_translation_article_id',
            'article_translation_short_title' => 'article_translation_short_title',
            'article_translation_long_title' => 'article_translation_long_title',
            'article_translation_slug' => 'article_translation_slug',
            'article_translation_description' => 'article_translation_description',
            'article_translation_lang' => 'article_translation_lang',
        );
    }

    public function initialize()
    {
        $this->belongsTo('article_translation_article_id', 'App\Core\Models\Article', 'id', array(
            'foreignKey' => true,
            'reusable' => true,
            'alias' => 'article',
        ));
    }

    public function beforeValidation()
    {
        if ($this->article_translation_slug == '') {
            $this->article_translation_slug = Slug::generate($this->article_translation_short_title).'-'.$this->article_translation_article_id;
        }
    }
}
