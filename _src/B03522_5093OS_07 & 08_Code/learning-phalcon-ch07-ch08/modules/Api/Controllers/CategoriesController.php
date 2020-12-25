<?php
namespace App\Api\Controllers;

class CategoriesController extends BaseController
{
    /**
     * @ApiDescription(section="Categories", description="Retrieve a list of categories")
     * @ApiMethod(type="get")
     * @ApiRoute(name="/categories")
     * @ApiParams(name="p", type="integer", nullable=true, description="Page number")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *  'items': [{
     *      'id':1,
     *      'category_is_active':1,
     *      'category_created_at':'2015-03-01 19:17:09',
     *      'category_updated_at':'2015-03-01 19:17:09',
     *      'category_translations': [{
     *          'category_translation_name':'Phalcon',
     *          'category_translation_slug':'phalcon',
     *          'category_translation_lang':'en'
     *      }]
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
            $manager = $this->getDI()->get('core_category_manager');
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
     * @ApiDescription(section="Categories", description="Retrieve a single category")
     * @ApiMethod(type="get")
     * @ApiRoute(name="/categories/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="Category id")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *  'items': [{
     *      'id':1,
     *      'category_is_active':1,
     *      'category_created_at':'2015-03-01 19:17:09',
     *      'category_updated_at':'2015-03-01 19:17:09',
     *      'category_translations': [{
     *          'category_translation_name':'Phalcon',
     *          'category_translation_slug':'phalcon',
     *          'category_translation_lang':'en'
     *      }]
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
            $manager = $this->getDI()->get('core_category_manager');

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
     * @ApiDescription(section="Categories", description="Update category")
     * @ApiMethod(type="put")
     * @ApiRoute(name="/categories/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="Category id")
     * @ApiParams(name="category_name", type="string", nullable=false, description="Category name")
     * @ApiParams(name="category_slug", type="string", nullable=true, description="Category slug")
     * @ApiParams(name="category_lang", type="string", nullable=true, description="Category language")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *    'id':1,
     *    'category_is_active':1,
     *    'category_created_at':'2015-03-01 19:17:09',
     *    'category_updated_at':'2015-03-01 19:17:09',
     *    'category_translations': [{
     *        'category_translation_name':'Phalcon',
     *        'category_translation_slug':'phalcon',
     *        'category_translation_lang':'en'
     *    }]
     * }")
     */
    public function updateAction($id)
    {
        try {
            $manager = $this->getDI()->get('core_category_manager');

            if ($this->request->getHeader('CONTENT_TYPE') == 'application/json') {
                $data = $this->request->getJsonRawBody(true);
            } else {
                $data = $this->request->getPut();
            }

            if (count($data) == 0) {
                throw new \Exception('Please provide data', 400);
            }

            $st_data = [
                'translations' => [
                    $data['category_translation_lang'] => [
                        'category_translation_name' => $data['category_translation_name'],
                        'category_translation_slug' => $data['category_translation_slug'],
                        'category_translation_lang' => $data['category_translation_lang'],
                    ]
                ],
                'id' => $id,
            ];

            $result = $manager->restUpdate($st_data);

            return $this->render($result);
        } catch (\Exception $e) {
            return $this->render([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    /**
     * @ApiDescription(section="Categories", description="Delete one category")
     * @ApiMethod(type="delete")
     * @ApiRoute(name="/categories/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="Category id")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="boolean", sample="true")
     */
    public function deleteAction($id)
    {
        try {
            $manager = $this->getDI()->get('core_category_manager');

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
     * @ApiDescription(section="Categories", description="Create a new category")
     * @ApiMethod(type="post")
     * @ApiRoute(name="/categories")
     * @ApiParams(name="category_translation_name", type="string", nullable=false, description="Category name")
     * @ApiParams(name="category_translation_slug", type="string", nullable=true, description="Category slug")
     * @ApiParams(name="category_translation_lang", type="string", nullable=false, description="Category language (ISO 2 letter code)")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *    'id':1,
     *    'category_is_active':1,
     *    'category_created_at':'2015-03-01 19:17:09',
     *    'category_updated_at':'2015-03-01 19:17:09',
     *    'category_translations': [{
     *        'category_translation_name':'Phalcon',
     *        'category_translation_slug':'phalcon',
     *        'category_translation_lang':'en'
     *    }]
     * }")
     */
    public function createAction()
    {
        try {
            $manager   = $this->getDI()->get('core_category_manager');

            if ($this->request->getHeader('CONTENT_TYPE') == 'application/json') {
                $data = $this->request->getJsonRawBody(true);
            } else {
                $data = $this->request->getPost();
            }

            if (count($data) == 0) {
                throw new \Exception('Please provide data', 400);
            }

            $st_data = [
                'translations' => [
                    $data['category_lang'] => [
                        'category_translation_name' => $data['category_translation_name'],
                        'category_translation_slug' => $data['category_translation_slug'],
                        'category_translation_lang' => $data['category_translation_lang'],
                    ]
                ],
                'category_is_active' => 1,
            ];

            $st_output = $manager->restCreate($st_data);

            return $this->render($st_output);
        } catch (\Exception $e) {
            return $this->render([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
