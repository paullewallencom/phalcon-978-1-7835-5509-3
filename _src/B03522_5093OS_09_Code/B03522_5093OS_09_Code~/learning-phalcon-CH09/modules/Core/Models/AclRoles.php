<?php

namespace App\Core\Models;

class AclRoles extends Base
{
    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $description;

    /**
     * Method to set the value of field name
     *
     * @param  integer $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field description
     *
     * @param  string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Returns the value of field name
     *
     * @return integer
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function getSource()
    {
        return 'acl_roles';
    }

    /**
     * @return AclRoles[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return AclRoles
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
            'name' => 'name',
            'description' => 'description'
        );
    }
}
