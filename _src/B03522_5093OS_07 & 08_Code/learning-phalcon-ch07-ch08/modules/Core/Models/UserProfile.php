<?php

namespace App\Core\Models;

use Phalcon\Mvc\Model\Behavior\Timestampable;

class UserProfile extends Base
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
    protected $user_profile_user_id;

    /**
     *
     * @var string
     */
    protected $user_profile_location;

    /**
     *
     * @var string
     */
    protected $user_profile_created_at;

    /**
     *
     * @var string
     */
    protected $user_profile_updated_at;

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
     * Method to set the value of field user_profile_user_id
     *
     * @param  integer $user_profile_user_id
     * @return $this
     */
    public function setUserProfileUserId($user_profile_user_id)
    {
        $this->user_profile_user_id = $user_profile_user_id;

        return $this;
    }

    /**
     * Method to set the value of field user_profile_location
     *
     * @param  string $user_profile_location
     * @return $this
     */
    public function setUserProfileLocation($user_profile_location)
    {
        $this->user_profile_location = $user_profile_location;

        return $this;
    }

    /**
     * Method to set the value of field user_profile_created_at
     *
     * @param  string $user_profile_created_at
     * @return $this
     */
    public function setUserProfileCreatedAt($user_profile_created_at)
    {
        $this->user_profile_created_at = $user_profile_created_at;

        return $this;
    }

    /**
     * Method to set the value of field user_profile_updated_at
     *
     * @param  string $user_profile_updated_at
     * @return $this
     */
    public function setUserProfileUpdatedAt($user_profile_updated_at)
    {
        $this->user_profile_updated_at = $user_profile_updated_at;

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
     * Returns the value of field user_profile_user_id
     *
     * @return integer
     */
    public function getUserProfileUserId()
    {
        return $this->user_profile_user_id;
    }

    /**
     * Returns the value of field user_profile_location
     *
     * @return string
     */
    public function getUserProfileLocation()
    {
        return $this->user_profile_location;
    }

    /**
     * Returns the value of field user_profile_created_at
     *
     * @return string
     */
    public function getUserProfileCreatedAt()
    {
        return $this->user_profile_created_at;
    }

    /**
     * Returns the value of field user_profile_updated_at
     *
     * @return string
     */
    public function getUserProfileUpdatedAt()
    {
        return $this->user_profile_updated_at;
    }

    public function getSource()
    {
        return 'user_profile';
    }

    /**
     * @return UserProfile[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return UserProfile
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
            'user_profile_user_id' => 'user_profile_user_id',
            'user_profile_location' => 'user_profile_location',
            'user_profile_created_at' => 'user_profile_created_at',
            'user_profile_updated_at' => 'user_profile_updated_at',
        );
    }

    public function initialize()
    {
        $this->hasOne('user_profile_user_id', 'App\Core\Models\User', 'id', array(
            'alias' => 'user',
            'reusable' => true,
        ));

        $this->addBehavior(new Timestampable(array(
            'beforeValidationOnCreate' => array(
                'field' => 'user_profile_created_at',
                'format' => 'Y-m-d H:i:s',
            ),
            'beforeValidationOnUpdate' => array(
                'field' => 'user_profile_updated_at',
                'format' => 'Y-m-d H:i:s',
            ),
        )));
    }
}
