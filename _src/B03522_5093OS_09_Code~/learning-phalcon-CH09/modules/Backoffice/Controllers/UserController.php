<?php
namespace App\Backoffice\Controllers;

class UserController extends BaseController
{
    public function indexAction()
    {
        return $this->dispatcher->forward(['action' => 'list']);
    }

    /**
     * List
     */
    public function listAction()
    {
        $page = $this->request->getQuery('p', 'int', 1);

        try {
            $records = $this->apiGet('users?p='.$page);

            $this->view->records = $records;
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }
    }

    /**
     * Renders the view to create a new record
     */
    public function addAction()
    {
        $manager = $this->getDI()->get('core_user_manager');
        $this->view->form = $manager->getForm();
    }

    /**
     * Renders the view to edit an existing record
     */
    public function editAction($id)
    {
        $manager = $this->getDI()->get('core_user_manager');
        $object  = $manager->findFirstById($id);

        if (!$object) {
            $this->flashSession->error('Object not found');

            return $this->response->redirect('user/list');
        }

        $this->persistent->set('id', $id);

        $this->view->form = $manager->getForm($object,['edit' => true]);
    }

    /**
     * Creates a new record
     * @return \Phalcon\Http\ResponseInterface
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect('user/list');
        }

        $manager = $this->getDI()->get('core_user_manager');
        $form    = $manager->getForm();

        if ($form->isValid($this->request->getPost())) {
            try {
                $manager   = $this->getDI()->get('core_user_manager');
                $post_data = $this->request->getPost();

                $manager->create($post_data);
                $this->flashSession->success('Object was created successfully');

                return $this->response->redirect('user/list');
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());

                return $this->dispatcher->forward(['action' => 'add']);
            }
        } else {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            return $this->dispatcher->forward(['action' => 'add', 'controller' => 'user']);
        }
    }

    /**
     * Updates a record
     * @return \Phalcon\Http\ResponseInterface
     */
    public function updateAction()
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect('user/list');
        }

        $manager    = $this->getDI()->get('core_user_manager');
        $object_id  = $this->persistent->get('id');
        $object     = $manager->findFirstById($object_id);
        $form       = $manager->getForm($object);

        if ($form->isValid($this->request->getPost())) {
            try {
                $manager = $this->getDI()->get('core_user_manager');
                $manager->update(array_merge($this->request->getPost(), ['id' => $object_id]));
                $this->flashSession->success('Object was updated successfully');

                return $this->response->redirect('user/list');
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());

                return $this->dispatcher->forward(['action' => 'edit']);
            }
        } else {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            return $this->dispatcher->forward(['action' => 'edit', 'controller' => 'user']);
        }
    }

    /**
     * Delete an existing record
     * @param  number                          $id
     * @return \Phalcon\Http\ResponseInterface
     */
    public function deleteAction($id)
    {
        if ($this->request->isPost()) {
            try {
                $manager = $this->getDI()->get('core_user_manager');
                $manager->delete($id);
                $this->flashSession->success('Object has been deleted successfully');
            } catch (\Exception $e) {
                $this->flashSession->error($e->getMessage());
            }

            return $this->response->redirect('user/list');
        }

        $this->view->id = $id;
    }
}
