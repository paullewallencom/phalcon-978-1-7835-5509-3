<?php
namespace App\Core\Security;

class Acl extends \Phalcon\Mvc\User\Plugin
{
    public function beforeDispatch(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();
        $redirect   = $this->getDI()->get('config')->auth->redirect;

        if ($controller == 'auth' && $action == 'signin') {
            return true;
        }

        $account = $this->auth->getIdentity();

        if (!$account) {
            if ($this->getDI()->get('auth')->hasRememberMe()) {
                return $this->getDI()->get('auth')->loginWithRememberMe();
            }
        }

        if (!is_array($account) || !array_key_exists('roles', $account)) {

            $this->view->disable();
            $this->response->setStatusCode(403, 'Forbidden');
            $this->flashSession->error('You are not allowed to access this section');

            return $this->response->redirect($redirect->failure);
        }

        $acl = $this->getDI()->get('acl');

        foreach ($account['roles'] as $role) {
            if ($acl->isAllowed($role, $controller, $action) == \Phalcon\Acl::ALLOW) {
                return true;
            }
        }

        $this->view->disable();
        $this->response->setStatusCode(403, 'Forbidden');

        return $this->response->redirect($redirect->failure);
    }
}
