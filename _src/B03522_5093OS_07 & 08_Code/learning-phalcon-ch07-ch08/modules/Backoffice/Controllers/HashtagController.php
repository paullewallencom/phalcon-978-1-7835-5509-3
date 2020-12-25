<?php
namespace App\Backoffice\Controllers;

class HashtagController extends BaseController
{
    public function indexAction()
    {
        return $this->dispatcher->forward(['action' => 'list']);
    }

    /**
     * Hashtags list
     */
    public function listAction()
    {
        $page = $this->request->getQuery('p', 'int', 1);

        try {
            $hashtags = $this->apiGet('hashtags?p='.$page);

            $this->view->hashtags = $hashtags;
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }
    }

    /**
     * Renders the view to create a new hashtag
     */
    public function addAction()
    {
        $manager = $this->getDI()->get('core_hashtag_manager');
        $this->view->form = $manager->getForm();
    }

    /**
     * Renders the view to edit an existing hashtag
     */
    public function editAction($id)
    {
        $manager = $this->getDI()->get('core_hashtag_manager');
        $hashtag = $manager->findFirstById($id);

        if (!$hashtag) {
            $this->flashSession->error('Object not found');

            return $this->response->redirect('hashtag/list');
        }

        $this->persistent->set('id', $id);

        $this->view->form = $manager->getForm($hashtag);
    }

    /**
     * Creates a new hashtag
     * @return \Phalcon\Http\ResponseInterface
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect('hashtag/list');
        }

        $manager = $this->getDI()->get('core_hashtag_manager');
        $form    = $manager->getForm();

        if ($form->isValid($this->request->getPost())) {
            try {
                $manager = $this->getDI()->get('core_hashtag_manager');
                $manager->create($this->request->getPost());
                $this->flashSession->success('Object was created successfully');

                return $this->response->redirect('hashtag/list');
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());

                return $this->dispatcher->forward(['action' => 'add']);
            }
        } else {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            return $this->dispatcher->forward(['action' => 'add', 'controller' => 'hashtag']);
        }
    }

    /**
     * Updates a new hashtag
     * @return \Phalcon\Http\ResponseInterface
     */
    public function updateAction()
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect('hashtag/list');
        }

        $manager    = $this->getDI()->get('core_hashtag_manager');
        $hashtag_id = $this->persistent->get('id');
        $hashtag    = $manager->findFirstById($hashtag_id);
        $form       = $manager->getForm($hashtag);

        if ($form->isValid($this->request->getPost())) {
            try {
                $manager = $this->getDI()->get('core_hashtag_manager');
                $manager->update([
                    'hashtag_name' => $this->request->getPost('hashtag_name',['string','trim']),
                    'id' => $hashtag_id
                ]);
                $this->flashSession->success('Object was updated successfully');

                return $this->response->redirect('hashtag/list');
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());

                return $this->dispatcher->forward(['action' => 'edit']);
            }
        } else {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            return $this->dispatcher->forward(['action' => 'edit', 'controller' => 'hashtag']);
        }
    }

    /**
     * Detelte an existing hastag
     * @param  number                          $id
     * @return \Phalcon\Http\ResponseInterface
     */
    public function deleteAction($id)
    {
        if ($this->request->isPost()) {
            try {
                $manager = $this->getDI()->get('core_hashtag_manager');
                $manager->delete($id);
                $this->flashSession->success('Item has been deleted successfully');
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }

            return $this->response->redirect('hashtag/list');
        }

        $this->view->id = $id;
    }
}
