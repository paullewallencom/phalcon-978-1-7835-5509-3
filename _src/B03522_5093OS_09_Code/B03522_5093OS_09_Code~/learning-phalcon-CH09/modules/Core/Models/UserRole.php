<?php

namespace App\Core\Models;

class UserRole extends Base
{
    /**
     *
     * @var string
     */
    protected $user_id;

    /**
     *
     * @var string
     */
    protected $user_role;

    /**
     * Method to set the value of field user_id
     *
     * @param  integer $user_id
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Method to set the value of field user_role
     *
     * @param  string $user_role
     * @return $this
     */
    public function setUserRole($user_role)
    {
        $this->user_role = $user_role;

        return $this;
    }

    /**
     * Returns the value of field user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Returns the value of field user_role
     *
     * @return string
     */
    public function getUserRole()
    {
        return $this->user_role;
    }

    public function getSource()
    {
        return 'user_role';
    }

    /**
     * @return UserGroup[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return UserGroup
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
            'user_id' => 'user_id',
            'user_role' => 'user_role'
        );
    }

    public function initialize()
    {
        $this->belongsTo('user_id', 'App\Core\Models\User', 'id', array(
            'foreignKey' => true,
            'reusable' => true,
            'alias' => 'user',
        ));

        $this->belongsTo('user_role', 'App\Core\Models\AclRoles', 'name', array(
            'foreignKey' => true,
            'reusable' => true,
            'alias' => 'role',
        ));
    }
}
