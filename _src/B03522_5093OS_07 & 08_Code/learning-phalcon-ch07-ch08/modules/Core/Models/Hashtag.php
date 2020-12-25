<?php

namespace App\Core\Models;

use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class Hashtag extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $hashtag_name;

    /**
     *
     * @var string
     */
    protected $hashtag_created_at;

    /**
     *
     * @var string
     */
    protected $hashtag_updated_at;

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
     * Method to set the value of field hashtag_name
     *
     * @param  string $hashtag_name
     * @return $this
     */
    public function setHashtagName($hashtag_name)
    {
        $this->hashtag_name = $hashtag_name;

        return $this;
    }

    /**
     * Method to set the value of field hashtag_created_at
     *
     * @param  string $hashtag_created_at
     * @return $this
     */
    public function setHashtagCreatedAt($hashtag_created_at)
    {
        $this->hashtag_created_at = $hashtag_created_at;

        return $this;
    }

    /**
     * Method to set the value of field hashtag_updated_at
     *
     * @param  string $hashtag_updated_at
     * @return $this
     */
    public function setHashtagUpdatedAt($hashtag_updated_at)
    {
        $this->hashtag_updated_at = $hashtag_updated_at;

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
     * Returns the value of field hashtag_name
     *
     * @return string
     */
    public function getHashtagName()
    {
        return $this->hashtag_name;
    }

    /**
     * Returns the value of field hashtag_created_at
     *
     * @return string
     */
    public function getHashtagCreatedAt()
    {
        return $this->hashtag_created_at;
    }

    /**
     * Returns the value of field hashtag_updated_at
     *
     * @return string
     */
    public function getHashtagUpdatedAt()
    {
        return $this->hashtag_updated_at;
    }

    public function getSource()
    {
        return 'hashtag';
    }

    /**
     * @return Hashtag[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return Hashtag
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
            'hashtag_name' => 'hashtag_name',
            'hashtag_created_at' => 'hashtag_created_at',
            'hashtag_updated_at' => 'hashtag_updated_at',
        );
    }
    public function initialize()
    {
        $this->hasManyToMany(
            "id",
            "App\Core\Models\ArticleHashtagArticle",
            "hashtag_id",
            "article_id",
            "App\Core\Models\Article",
            "id",
            array('alias' => 'articles')
        );

        $this->addBehavior(new Timestampable(array(
            'beforeValidationOnCreate' => array(
                'field' => 'hashtag_created_at',
                'format' => 'Y-m-d H:i:s',
            ),
            'beforeValidationOnUpdate' => array(
                'field' => 'hashtag_updated_at',
                'format' => 'Y-m-d H:i:s',
            ),
        )));
    }

    public function validation()
    {
        $this->validate(new Uniqueness([
            "field" => "hashtag_name",
            "message" => "This hashtag already exists",
        ]));

        return $this->validationHasFailed() != true;
    }

}
