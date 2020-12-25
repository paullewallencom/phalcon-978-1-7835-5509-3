<?php

namespace App\Core\Models;

use Phalcon\Mvc\Model\Behavior\Timestampable;

class Category extends Base
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
    protected $category_is_active;

    /**
     *
     * @var string
     */
    protected $category_created_at;

    /**
     *
     * @var string
     */
    protected $category_updated_at;

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
     * Method to set the value of field category_is_active
     *
     * @param  integer $category_is_active
     * @return $this
     */
    public function setCategoryIsActive($category_is_active)
    {
        $this->category_is_active = $category_is_active;

        return $this;
    }

    /**
     * Method to set the value of field category_created_at
     *
     * @param  string $category_created_at
     * @return $this
     */
    public function setCategoryCreatedAt($category_created_at)
    {
        $this->category_created_at = $category_created_at;

        return $this;
    }

    /**
     * Method to set the value of field category_updated_at
     *
     * @param  string $category_updated_at
     * @return $this
     */
    public function setCategoryUpdatedAt($category_updated_at)
    {
        $this->category_updated_at = $category_updated_at;

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
     * Returns the value of field category_is_active
     *
     * @return integer
     */
    public function getCategoryIsActive()
    {
        return $this->category_is_active;
    }

    /**
     * Returns the value of field category_created_at
     *
     * @return string
     */
    public function getCategoryCreatedAt()
    {
        return $this->category_created_at;
    }

    /**
     * Returns the value of field category_updated_at
     *
     * @return string
     */
    public function getCategoryUpdatedAt()
    {
        return $this->category_updated_at;
    }

    public function getSource()
    {
        return 'category';
    }

    /**
     * @return Category[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return Category
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
            'category_is_active' => 'category_is_active',
            'category_created_at' => 'category_created_at',
            'category_updated_at' => 'category_updated_at',
        );
    }

    public function initialize()
    {
        $this->hasManyToMany(
            "id",
            "App\Core\Models\ArticleCategoryArticle",
            "category_id",
            "article_id",
            "App\Core\Models\Article",
            "id",
            array('alias' => 'articles')
        );

        $this->hasMany('id', 'App\Core\Models\CategoryTranslation', 'category_translation_category_id', array(
            'alias' => 'translations',
            'foreignKey' => [
                'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE,
            ]
        ));

        $this->addBehavior(new Timestampable(array(
            'beforeValidationOnCreate' => array(
                'field' => 'category_created_at',
                'format' => 'Y-m-d H:i:s',
            ),
            'beforeValidationOnUpdate' => array(
                'field' => 'category_updated_at',
                'format' => 'Y-m-d H:i:s',
            ),
        )));
    }

    public function getTranslations($arguments = null)
    {
        return $this->getRelated('translations', $arguments);
    }

    public function toArray($columns = null)
    {
        $output = parent::toArray($columns);

        $output['category_translations'] = $this->getTranslations([
            'columns' => [
                'category_translation_name',
                'category_translation_slug',
                'category_translation_lang',
            ],
        ])->toArray();

        return $output;
    }
}
