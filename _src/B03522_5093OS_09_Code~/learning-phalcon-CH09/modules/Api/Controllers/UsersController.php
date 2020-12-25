<?php
namespace App\Api\Controllers;

class UsersController extends BaseController
{
    /**
     * @ApiDescription(section="Users", description="Retrieve a list of users")
     * @ApiMethod(type="get")
     * @ApiRoute(name="/users")
     * @ApiParams(name="p", type="integer", nullable=true, description="Page number")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *  'items': [{
     *      'id':1,
     *      'user_first_name':'John',
     *      'user_last_name':'Doe',
     *      'user_email':'john.doe@learning-phalcon.dev',
     *      'user_is_active':'1',
     *      'user_created_at':'2015-03-01 19:17:09',
     *      'user_updated_at':'2015-03-01 19:17:09',
     *      'user_profile': [{
     *          'id':'1',
     *          'user_profile_user_id':'1',
     *          'user_profile_location':'Barcelona',
     *          'user_profile_created_at':'2015-03-01 19:17:09',
     *          'user_profile_updated_at':'2015-03-01 19:17:09'
     *      }]
     *  }],
     *  'before':1,
     *  'first':1,
     *  'next':1,
     *  'last':1,
     *  'current':1,
     *  'total_pages':1,
     *  'total_items':2
     * }")
     */
    public function listAction()
    {
        try {
            $manager = $this->getDI()->get('core_user_manager');
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
     * @ApiDescription(section="Users", description="Retrieve a single user")
     * @ApiMethod(type="get")
     * @ApiRoute(name="/users/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="User id")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *  'items': [{
     *      'id':1,
     *      'user_first_name':'John',
     *      'user_last_name':'Doe',
     *      'user_email':'john.doe@learning-phalcon.dev',
     *      'user_is_active':'1',
     *      'user_created_at':'2015-03-01 19:17:09',
     *      'user_updated_at':'2015-03-01 19:17:09',
     *      'user_profile': [{
     *          'id':'1',
     *          'user_profile_user_id':'1',
     *          'user_profile_location':'Barcelona',
     *          'user_profile_created_at':'2015-03-01 19:17:09',
     *          'user_profile_updated_at':'2015-03-01 19:17:09'
     *      }]
     *  }],
     *  'before':1,
     *  'first':1,
     *  'next':1,
     *  'last':1,
     *  'current':1,
     *  'total_pages':1,
     *  'total_items':1
     * }")
     */
    public function getAction($id)
    {
        try {
            $manager = $this->getDI()->get('core_user_manager');

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
     * @ApiDescription(section="Users", description="Update category")
     * @ApiMethod(type="put")
     * @ApiRoute(name="/users/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="User id")
     * @ApiParams(name="user_first_name", type="string", nullable=false, description="First name")
     * @ApiParams(name="user_last_name", type="string", nullable=true, description="Last name")
     * @ApiParams(name="user_email", type="string", nullable=false, description="A valid email")
     * @ApiParams(name="user_password", type="string", nullable=false, description="Password")
     * @ApiParams(name="user_is_active", type="int", nullable=false, description="1 || 0")
     * @ApiParams(name="user_profile_location", type="string", nullable=true, description="User location (city, country, etc)")
     * @ApiParams(name="user_acl_role", type="string", nullable=false, description="Acl role (Administrator, Guest, etc)")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *    'id':1,
     *    'user_first_name':'John',
     *    'user_last_name':'Doe',
     *    'user_email':'johndoe@domain.tld',
     *    'user_is_active':1,
     *    'user_created_at':'2015-03-01 19:17:09',
     *    'user_updated_at':'2015-03-01 19:17:09',
     *    'user_profile': {
     *        'id':1,
     *        'user_profile_user_id':1,
     *        'user_profile_location':'Barcelona, Spain',
     *        'user_profile_created_at':'2015-03-01 19:17:09',
     *        'user_profile_updated_at':'2015-03-01 19:17:09',
     *    }
     * }")
     */
    public function updateAction($id)
    {
        try {
            $manager = $this->getDI()->get('core_user_manager');

            if ($this->request->getHeader('CONTENT_TYPE') == 'application/json') {
                $data = $this->request->getJsonRawBody(true);
            } else {
                $data = $this->request->getPut();
            }

            if (count($data) == 0) {
                throw new \Exception('Please provide data', 400);
            }

            $st_data = array_merge($data, ['id' => $id]);
            $result  = $manager->restUpdate($st_data);

            return $this->render($result);
        } catch (\Exception $e) {
            return $this->render([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    /**
     * @ApiDescription(section="Users", description="Delete one user")
     * @ApiMethod(type="delete")
     * @ApiRoute(name="/users/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="User id")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="boolean", sample="true")
     */
    public function deleteAction($id)
    {
        try {
            $manager = $this->getDI()->get('core_user_manager');

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
     * @ApiDescription(section="Users", description="Create a new user")
     * @ApiMethod(type="post")
     * @ApiRoute(name="/users")
     * @ApiParams(name="user_first_name", type="string", nullable=false, description="First name")
     * @ApiParams(name="user_last_name", type="string", nullable=true, description="Last name")
     * @ApiParams(name="user_email", type="string", nullable=false, description="A valid email")
     * @ApiParams(name="user_password", type="string", nullable=false, description="Password")
     * @ApiParams(name="user_is_active", type="int", nullable=false, description="1 || 0")
     * @ApiParams(name="user_profile_location", type="string", nullable=true, description="User location (city, country, etc)")
     * @ApiParams(name="user_acl_role", type="string", nullable=false, description="Acl role (Administrator, Guest, etc)")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *    'id':1,
     *    'user_first_name':'John',
     *    'user_last_name':'Doe',
     *    'user_email':'johndoe@domain.tld',
     *    'user_is_active':1,
     *    'user_created_at':'2015-03-01 19:17:09',
     *    'user_updated_at':'2015-03-01 19:17:09',
     *    'user_profile': {
     *        'id':1,
     *        'user_profile_user_id':1,
     *        'user_profile_location':'Barcelona, Spain',
     *        'user_profile_created_at':'2015-03-01 19:17:09',
     *        'user_profile_updated_at':'2015-03-01 19:17:09',
     *    }
     * }")
     */
    public function createAction()
    {
        try {
            $manager   = $this->getDI()->get('core_user_manager');

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
