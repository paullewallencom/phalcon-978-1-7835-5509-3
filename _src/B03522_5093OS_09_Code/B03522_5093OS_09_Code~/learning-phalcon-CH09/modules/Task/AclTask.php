<?php
class AclTask extends BaseTask
{
    /**
     *
     * @var \Phalcon\Acl\Adapter\Database
     */
    private $acl;

    public function __construct()
    {
        $this->acl = $this->getDI()->get('acl');
    }

    /**
     * @Description("Install the initial(default) acl resources")
     */
    public function initAction()
    {
        $roles = array(
            'Administrator' => new \Phalcon\Acl\Role('Administrator'),
            'Guest' => new \Phalcon\Acl\Role('Guest'),
        );

        foreach ($roles as $role) {
            $this->acl->addRole($role);
        }

        $userResources = array(
            'index' => array('index'),
        );

        foreach ($userResources as $resource => $actions) {
            $this->acl->addResource(new \Phalcon\Acl\Resource($resource), $actions);
            foreach ($actions as $action) {
                $this->acl->allow('Administrator', $resource, $action);
            }
        }

        $this->consoleLog('Default resources created');
    }
}
