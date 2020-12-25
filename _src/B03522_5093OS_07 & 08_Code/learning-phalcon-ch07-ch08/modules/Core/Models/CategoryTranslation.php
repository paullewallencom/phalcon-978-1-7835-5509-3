<?php

namespace App\Core\Models;

use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Utils\Slug;

class CategoryTranslation extends Base
{

    /**
     *
     * @var integer
     */
    protected $category_translation_category_id;

    /**
     *
     * @var string
     */
    protected $category_translation_name;

    /**
     *
     * @var string
     */
    protected $category_translation_slug;

    /**
     *
     * @var string
     */
    protected $category_translation_lang;

    /**
     * Method to set the value of field category_translation_category_id
     *
     * @param  integer $category_translation_category_id
     * @return $this
     */
    public function setCategoryTranslationCategoryId($category_translation_category_id)
    {
        $this->category_translation_category_id = $category_translation_category_id;

        return $this;
    }

    /**
     * Method to set the value of field category_translation_name
     *
     * @param  string $category_translation_name
     * @return $this
     */
    public function setCategoryTranslationName($category_translation_name)
    {
        $this->category_translation_name = $category_translation_name;

        return $this;
    }

    /**
     * Method to set the value of field category_translation_slug
     *
     * @param  string $category_translation_slug
     * @return $this
     */
    public function setCategoryTranslationSlug($category_translation_slug)
    {
        $this->category_translation_slug = $category_translation_slug;

        return $this;
    }

    /**
     * Method to set the value of field category_translation_lang
     *
     * @param  string $category_translation_lang
     * @return $this
     */
    public function setCategoryTranslationLang($category_translation_lang)
    {
        $this->category_translation_lang = $category_translation_lang;

        return $this;
    }

    /**
     * Returns the value of field category_translation_category_id
     *
     * @return integer
     */
    public function getCategoryTranslationCategoryId()
    {
        return $this->category_translation_category_id;
    }

    /**
     * Returns the value of field category_translation_name
     *
     * @return string
     */
    public function getCategoryTranslationName()
    {
        return $this->category_translation_name;
    }

    /**
     * Returns the value of field category_translation_slug
     *
     * @return string
     */
    public function getCategoryTranslationSlug()
    {
        return $this->category_translation_slug;
    }

    /**
     * Returns the value of field category_translation_lang
     *
     * @return string
     */
    public function getCategoryTranslationLang()
    {
        return $this->category_translation_lang;
    }

    public function getSource()
    {
        return 'category_translation';
    }

    /**
     * @return CategoryTranslation[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return CategoryTranslation
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
            'category_translation_category_id' => 'category_translation_category_id',
            'category_translation_name' => 'category_translation_name',
            'category_translation_slug' => 'category_translation_slug',
            'category_translation_lang' => 'category_translation_lang',
        );
    }

    public function initialize()
    {
        $this->belongsTo('category_translation_category_id', 'App\Core\Models\Category', 'id', array(
            'foreignKey' => true,
            'reusable' => true,
            'alias' => 'category',
        ));
    }

    public function validation()
    {
        $this->validate(new Uniqueness(array(
            "field" => "category_translation_slug",
            "message" => "Category slug should be unique",
        )));

        return $this->validationHasFailed() != true;
    }

    public function beforeValidation()
    {
        if ($this->category_translation_slug == '') {
            $this->category_translation_slug = Slug::generate($this->category_translation_name).'-'.$this->category_translation_category_id;
        }
    }
}
