<?php
namespace App\Api\Controllers;

class HashtagsController extends BaseController
{
    /**
     * @ApiDescription(section="Hashtags", description="Retrieve a list of hashtags")
     * @ApiMethod(type="get")
     * @ApiRoute(name="/hashtags")
     * @ApiParams(name="p", type="integer", nullable=true, description="Page number")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *  'items': [{
     *      'id':'int',
     *      'hashtag_name':'int',
     *      'hashtag_created_at':'string',
     *      'hashtag_updated_at':'string'
     *  }],
     *  'before':'int',
     *  'first':'int',
     *  'next':'int',
     *  'last':'int',
     *  'current':'int',
     *  'total_pages':'int',
     *  'total_items':'int',
     * }")
     */
    public function listAction()
    {
        try {
            $manager = $this->getDI()->get('core_hashtag_manager');
            $page    = $this->request->getQuery('p', 'int', 0);

            $st_output = $manager->restGet([], [], $page);

            return $this->render($st_output);
        } catch (\Exception $e) {
            return $this->render([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    /**
     * @ApiDescription(section="Hashtags", description="Retrieve a single hashtag")
     * @ApiMethod(type="get")
     * @ApiRoute(name="/hashtags/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="Hashtag id")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *  'items': [{
     *      'id':'int',
     *      'hashtag_name':'int',
     *      'hashtag_created_at':'string',
     *      'hashtag_updated_at':'string'
     *  }],
     *  'before':'int',
     *  'first':'int',
     *  'next':'int',
     *  'last':'int',
     *  'current':'int',
     *  'total_pages':'int',
     *  'total_items':'int',
     * }")
     */
    public function getAction($id)
    {
        try {
            $manager = $this->getDI()->get('core_hashtag_manager');

            $st_output = $manager->restGet([
                'id = :id:',
                'bind' => [
                    'id' => $id,
                ],
            ]);

            return $this->render($st_output);
        } catch (\Exception $e) {
            return $this->render([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    /**
     * @ApiDescription(section="Hashtags", description="Update hashtag")
     * @ApiMethod(type="put")
     * @ApiRoute(name="/hashtags/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="Hashtag id")
     * @ApiParams(name="hashtag_name", type="string", nullable=false, description="Hashtag name")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *    'id':1,
     *    'hashtag_name':'phalcon',
     *    'hashtag_created_at':'2015-02-28 13:12:00',
     *    'hashtag_updated_at':'2015-02-28 14:15:00'
     * }")
     */
    public function updateAction($id)
    {
        try {
            $manager = $this->getDI()->get('core_hashtag_manager');

            if ($this->request->getHeader('CONTENT_TYPE') == 'application/json') {
                $data = $this->request->getJsonRawBody(true);
            } else {
                $data = [$this->request->getPut()];
            }

            if (count($data[0]) == 0) {
                throw new \Exception('Please provide data', 400);
            }

            $data = array_merge($data[0], ['id' => $id]);

            $result = $manager->restUpdate($data);

            return $this->render($result);
        } catch (\Exception $e) {
            return $this->render([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    /**
     * @ApiDescription(section="Hashtags", description="Delete one hashtag")
     * @ApiMethod(type="delete")
     * @ApiRoute(name="/hashtags/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="Hashtag id")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="boolean", sample="true")
     */
    public function deleteAction($id)
    {
        try {
            $manager = $this->getDI()->get('core_hashtag_manager');

            $st_output = $manager->restDelete($id);

            return $this->render($st_output);
        } catch (\Exception $e) {
            return $this->render([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    /**
     * @ApiDescription(section="Hashtags", description="Create a new hashtag")
     * @ApiMethod(type="post")
     * @ApiRoute(name="/hashtags")
     * @ApiParams(name="hashtag_name", type="string", nullable=false, description="Hashtag name")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *    'id':1,
     *    'hashtag_name':'phalcon',
     *    'hashtag_created_at':'2015-02-28 13:12:00',
     *    'hashtag_updated_at':''
     * }")
     */
    public function createAction()
    {
        try {
            $manager   = $this->getDI()->get('core_hashtag_manager');

            if ($this->request->getHeader('CONTENT_TYPE') == 'application/json') {
                $data = $this->request->getJsonRawBody(true);
            } else {
                $data = $this->request->getPost();
            }

            if (count($data) == 0) {
                throw new \Exception('Please provide data', 400);
            }

            $st_output = $manager->restCreate($data);

            return $this->render($st_output);
        } catch (\Exception $e) {
            return $this->render([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
