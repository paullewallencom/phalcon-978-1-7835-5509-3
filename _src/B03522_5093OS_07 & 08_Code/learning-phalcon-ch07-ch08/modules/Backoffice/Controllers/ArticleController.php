<?php
namespace App\Backoffice\Controllers;

class ArticleController extends BaseController
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
            $records = $this->apiGet('articles?p='.$page);

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
        $manager = $this->getDI()->get('core_article_manager');
        $this->view->form = $manager->getForm();
    }

    /**
     * Renders the view to edit an existing record
     */
    public function editAction($id)
    {
        $manager = $this->getDI()->get('core_article_manager');
        $object  = $manager->findFirstById($id);

        if (!$object) {
            $this->flashSession->error('Object not found');

            return $this->response->redirect('article/list');
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
            return $this->response->redirect('article/list');
        }

        $manager = $this->getDI()->get('core_article_manager');
        $form    = $manager->getForm();

        if ($form->isValid($this->request->getPost())) {
            try {
                $manager   = $this->getDI()->get('core_article_manager');
                $post_data = $this->request->getPost();
                $data      = array_merge($post_data, [
                    'article_user_id' => $this->auth->getUserId()
                ]);

                $manager->create($data);
                $this->flashSession->success('Object was created successfully');

                return $this->response->redirect('article/list');
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());

                return $this->dispatcher->forward(['action' => 'add']);
            }
        } else {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            return $this->dispatcher->forward(['action' => 'add', 'controller' => 'article']);
        }
    }

    /**
     * Updates a record
     * @return \Phalcon\Http\ResponseInterface
     */
    public function updateAction()
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect('article/list');
        }

        $manager    = $this->getDI()->get('core_article_manager');
        $object_id  = $this->persistent->get('id');
        $object     = $manager->findFirstById($object_id);
        $form       = $manager->getForm($object);

        if ($form->isValid($this->request->getPost())) {
            try {
                $manager   = $this->getDI()->get('core_article_manager');
                $post_data = $this->request->getPost();
                $data      = array_merge($post_data, [
                    'article_user_id' => $this->auth->getUserId(),
                    'id' => $object_id
                ]);

                $manager->update($data);
                $this->flashSession->success('Object was updated successfully');

                return $this->response->redirect('article/list');
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());

                return $this->dispatcher->forward(['action' => 'edit']);
            }
        } else {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            return $this->dispatcher->forward(['action' => 'edit', 'controller' => 'category']);
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
                $manager = $this->getDI()->get('core_article_manager');
                $manager->delete($id);
                $this->flashSession->success('Object has been deleted successfully');
            } catch (\Exception $e) {
                $this->flashSession->error($e->getMessage());
            }

            return $this->response->redirect('article/list');
        }

        $this->view->id = $id;
    }
}
