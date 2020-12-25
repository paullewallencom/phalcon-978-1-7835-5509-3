<?php
namespace App\Core\Models;

class Article extends Base
{
    protected $id;
    protected $article_short_title;
    protected $article_long_title;
    protected $article_slug;
    protected $article_description;
    protected $is_published;
    protected $created_at;
    protected $updated_at;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setArticleShortTitle($article_short_title)
    {
        $this->article_short_title = $article_short_title;

        return $this;
    }

    public function setArticleLongTitle($article_long_title)
    {
        $this->article_long_title = $article_long_title;

        return $this;
    }

    public function setArticleSlug($article_slug)
    {
        $this->article_slug = $article_slug;

        return $this;
    }

    public function setArticleDescription($article_description)
    {
        $this->article_description = $article_description;

        return $this;
    }

    public function setIsPublished($is_published)
    {
        $this->is_published = $is_published;

        return $this;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getArticleShortTitle()
    {
        return $this->article_short_title;
    }

    public function getArticleLongTitle()
    {
        return $this->article_long_title;
    }

    public function getArticleSlug()
    {
        return $this->article_slug;
    }

    public function getArticleDescription()
    {
        return $this->article_description;
    }

    public function getIsPublished()
    {
        return $this->is_published;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
