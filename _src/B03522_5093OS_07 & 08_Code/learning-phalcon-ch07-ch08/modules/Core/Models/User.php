<?php

namespace App\Core\Models;

use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\Email;

class User extends Base
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
    protected $user_first_name;

    /**
     *
     * @var string
     */
    protected $user_last_name;

    /**
     *
     * @var string
     */
    protected $user_email;

    /**
     *
     * @var string
     */
    protected $user_password;

    /**
     *
     * @var integer
     */
    protected $user_group_id;

    /**
     *
     * @var integer
     */
    protected $user_is_active;

    /**
     *
     * @var string
     */
    protected $user_created_at;

    /**
     *
     * @var string
     */
    protected $user_updated_at;

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
     * Method to set the value of field user_first_name
     *
     * @param  string $user_first_name
     * @return $this
     */
    public function setUserFirstName($user_first_name)
    {
        $this->user_first_name = $user_first_name;

        return $this;
    }

    /**
     * Method to set the value of field user_last_name
     *
     * @param  string $user_last_name
     * @return $this
     */
    public function setUserLastName($user_last_name)
    {
        $this->user_last_name = $user_last_name;

        return $this;
    }

    /**
     * Method to set the value of field user_email
     *
     * @param  string $user_email
     * @return $this
     */
    public function setUserEmail($user_email)
    {
        $this->user_email = $user_email;

        return $this;
    }

    /**
     * Method to set the value of field user_password
     *
     * @param  string $user_password
     * @return $this
     */
    public function setUserPassword($user_password)
    {
        $this->user_password = $user_password;

        return $this;
    }

    /**
     * Method to set the value of field user_group_id
     *
     * @param  integer $user_group_id
     * @return $this
     */
    public function setUserGroupId($user_group_id)
    {
        $this->user_group_id = $user_group_id;

        return $this;
    }

    /**
     * Method to set the value of field user_is_active
     *
     * @param  integer $user_is_active
     * @return $this
     */
    public function setUserIsActive($user_is_active)
    {
        $this->user_is_active = $user_is_active;

        return $this;
    }

    /**
     * Method to set the value of field user_created_at
     *
     * @param  string $user_created_at
     * @return $this
     */
    public function setUserCreatedAt($user_created_at)
    {
        $this->user_created_at = $user_created_at;

        return $this;
    }

    /**
     * Method to set the value of field user_updated_at
     *
     * @param  string $user_updated_at
     * @return $this
     */
    public function setUserUpdatedAt($user_updated_at)
    {
        $this->user_updated_at = $user_updated_at;

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
     * Returns the value of field user_first_name
     *
     * @return string
     */
    public function getUserFirstName()
    {
        return $this->user_first_name;
    }

    /**
     * Returns the value of field user_last_name
     *
     * @return string
     */
    public function getUserLastName()
    {
        return $this->user_last_name;
    }

    /**
     * Returns the value of field user_email
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * Returns the value of field user_password
     *
     * @return string
     */
    public function getUserPassword()
    {
        return $this->user_password;
    }

    /**
     * Returns the value of field user_group_id
     *
     * @return integer
     */
    public function getUserGroupId()
    {
        return $this->user_group_id;
    }

    /**
     * Returns the value of field user_is_active
     *
     * @return integer
     */
    public function getUserIsActive()
    {
        return $this->user_is_active;
    }

    /**
     * Returns the value of field user_created_at
     *
     * @return string
     */
    public function getUserCreatedAt()
    {
        return $this->user_created_at;
    }

    /**
     * Returns the value of field user_updated_at
     *
     * @return string
     */
    public function getUserUpdatedAt()
    {
        return $this->user_updated_at;
    }

    public function getSource()
    {
        return 'user';
    }

    /**
     * @return User[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return User
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
            'user_first_name' => 'user_first_name',
            'user_last_name' => 'user_last_name',
            'user_email' => 'user_email',
            'user_password' => 'user_password',
            'user_group_id' => 'user_group_id',
            'user_is_active' => 'user_is_active',
            'user_created_at' => 'user_created_at',
            'user_updated_at' => 'user_updated_at',
        );
    }

    public function toArray($columns = null)
    {
        $output = parent::toArray($columns);

        unset($output['user_password']);

        $output['user_profile'] = $this->profile->toArray();

        return $output;
    }

    public function initialize()
    {
        $this->hasOne('id', 'App\Core\Models\UserProfile', 'user_profile_user_id', array(
            'alias' => 'profile',
            'reusable' => true,
            'foreignKey' => array(
                'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE,
            ),
        ));

        $this->hasMany('id', 'App\Core\Models\UserFailedLogins', 'user_id', array(
            'alias' => 'failedLogins',
            'foreignKey' => array(
                'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE,
            ),
        ));

        $this->hasMany('id', 'App\Core\Models\UserSuccessLogins', 'user_id', array(
            'alias' => 'successLogins',
            'foreignKey' => array(
                'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE,
            ),
        ));

        $this->hasMany('id', 'App\Core\Models\UserRememberTokens', 'user_id', array(
            'alias' => 'rememberTokens',
            'foreignKey' => array(
                'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE,
            ),
        ));

        $this->hasMany('id', 'App\Core\Models\UserRole', 'user_id', array(
            'alias' => 'roles',
            'foreignKey' => array(
                'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE,
            ),
        ));

        $this->addBehavior(new Timestampable(array(
            'beforeValidationOnCreate' => array(
                'field' => 'user_created_at',
                'format' => 'Y-m-d H:i:s',
            ),
            'beforeValidationOnUpdate' => array(
                'field' => 'user_updated_at',
                'format' => 'Y-m-d H:i:s',
            ),
        )));
    }

    public function validation()
    {
        $this->validate(new Email(array(
            "field" => "user_email",
            "message" => "Invalid email address",
        )));

        $this->validate(new Uniqueness(array(
            "field" => "user_email",
            "message" => "The email is already registered",
        )));

        return $this->validationHasFailed() != true;
    }
}
