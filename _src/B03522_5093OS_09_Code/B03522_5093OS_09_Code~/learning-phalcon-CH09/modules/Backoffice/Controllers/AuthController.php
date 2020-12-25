<?php
namespace App\Backoffice\Controllers;

use App\Core\Forms\UserSigninForm;

class AuthController extends BaseController
{
    /**
     * Authenticate user
     */
    public function signinAction()
    {
        $form = new UserSigninForm();

        if ($this->request->isPost()) {
            try {
                $this->auth->signin($form);
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }

        $this->view->signinForm = $form;
    }

    /**
     * Remove session / signout user
     * @return \Phalcon\Http\ResponseInterface
     */
    public function signoutAction()
    {
        $this->auth->remove();

        return $this->response->redirect('auth/signin');
    }
}
