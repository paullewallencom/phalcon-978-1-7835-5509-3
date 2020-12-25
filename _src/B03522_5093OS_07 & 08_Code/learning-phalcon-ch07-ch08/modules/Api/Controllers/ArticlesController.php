<?php
namespace App\Api\Controllers;

class ArticlesController extends BaseController
{
    /**
     * @ApiDescription(section="Articles", description="Retrieve a list of articles")
     * @ApiMethod(type="get")
     * @ApiRoute(name="/articles")
     * @ApiParams(name="p", type="integer", nullable=true, description="Page number")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *  'items': [{
     *      'id':'int',
     *      'article_user_id':'int',
     *      'article_is_published':'int',
     *      'article_created_at':'string',
     *      'article_updated_at':'string',
     *      'article_translations':[{
     *          'article_translation_short_title':'string',
     *          'article_translation_long_title':'string',
     *          'article_translation_slug':'string',
     *          'article_translation_description':'string',
     *          'article_translation_lang':'string'
     *      }],
     *      'article_categories':[{
     *          'id':'int',
     *          'category_translations':[{
     *              'category_translation_name':'string',
     *              'category_translation_slug':'string',
     *              'category_translation_lang':'string'
     *          }]
     *      }],
     *      'article_hashtags':[{
     *          'id':'int',
     *          'hashtag_name':'string'
     *      }],
     *      'article_author':{
     *          'user_first_name':'string',
     *          'user_last_name':'string',
     *          'user_email':'string'
     *      }
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
            $manager = $this->getDI()->get('core_article_manager');
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
     * @ApiDescription(section="Articles", description="Retrieve a single article")
     * @ApiMethod(type="get")
     * @ApiRoute(name="/articles/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="Article id")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{
     *  'items': [{
     *      'id':'int',
     *      'article_user_id':'int',
     *      'article_is_published':'int',
     *      'article_created_at':'string',
     *      'article_updated_at':'string',
     *      'article_translations':[{
     *          'article_translation_short_title':'string',
     *          'article_translation_long_title':'string',
     *          'article_translation_slug':'string',
     *          'article_translation_description':'string',
     *          'article_translation_lang':'string'
     *      }],
     *      'article_categories':[{
     *          'id':'int',
     *          'category_translations':[{
     *              'category_translation_name':'string',
     *              'category_translation_slug':'string',
     *              'category_translation_lang':'string'
     *          }]
     *      }],
     *      'article_hashtags':[{
     *          'id':'int',
     *          'hashtag_name':'string'
     *      }],
     *      'article_author':{
     *          'user_first_name':'string',
     *          'user_last_name':'string',
     *          'user_email':'string'
     *      }
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
            $manager = $this->getDI()->get('core_article_manager');

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
     * @ApiDescription(section="Articles", description="Update an article")
     * @ApiMethod(type="put")
     * @ApiRoute(name="/articles/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="Article id")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="boolean", sample="true")
     */
    public function updateAction($id)
    {
        try {
            $manager = $this->getDI()->get('core_article_manager');

            if ($this->request->getHeader('CONTENT_TYPE') == 'application/json') {
                $data = $this->request->getJsonRawBody(true);
            } else {
                $data = $this->request->getPut();
            }

            if (count($data) == 0) {
                throw new \Exception('Please provide data', 400);
            }

            $st_inputData = array(
                'article_user_id' => $data['article_user_id'],
                'article_is_published' => $data['article_is_published'],
                'translations' => [
                    $data['article_translation_lang'] => [
                        'article_translation_short_title' => $data['article_translation_short_title'],
                        'article_translation_long_title' => $data['article_translation_long_title'],
                        'article_translation_description' => $data['article_translation_description'],
                        'article_translation_slug' => $data['article_translation_slug'],
                        'article_translation_lang' => $data['article_translation_lang'],
                    ],
                ],
                'categories' => $data['categories'],
                'hashtags' => $data['hashtags']
            );

            $result = $manager->restUpdate(array_merge($st_inputData, ['id' => $id]));

            return $this->render($result);
        } catch (\Exception $e) {
            return $this->render([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    /**
     * @ApiDescription(section="Articles", description="Delete an article")
     * @ApiMethod(type="delete")
     * @ApiRoute(name="/articles/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="Article id")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="boolean", sample="true")
     */
    public function deleteAction($id)
    {
        try {
            $manager = $this->getDI()->get('core_article_manager');

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
     * @ApiDescription(section="Articles", description="Create a new article")
     * @ApiMethod(type="post")
     * @ApiRoute(name="/articles")
     * @ApiParams(name="article_user_id", type="integer", nullable=false, description="User id")
     * @ApiParams(name="article_is_published", type="integer", nullable=false, description="Article is published or not")
     * @ApiParams(name="article_translation_short_title", type="string", nullable=false, description="Article title")
     * @ApiParams(name="article_translation_long_title", type="string", nullable=false, description="Article long title")
     * @ApiParams(name="article_translation_description", type="string", nullable=false, description="Article content/description")
     * @ApiParams(name="article_translation_slug", type="string", nullable=true, description="Article slug")
     * @ApiParams(name="article_translation_lang", type="string", nullable=false, description="Article trnslation language")
     * @ApiParams(name="categories", type="integer", nullable=false, description="CSV values of existing categories ids. Ex: 5,18,32")
     * @ApiParams(name="hashtags", type="integer", nullable=false, description="CSV values of existing hashtags ids. Ex: 15,142,11")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="boolean", sample="{
     *  'id': '24',
     *  'article_user_id': 14,
     *  'article_is_published': 1,
     *  'article_created_at': '2015-03-12 16:42:17',
     *  'article_updated_at': null,
     *  'article_translations': [
     *      {
     *          'article_translation_short_title': 'Test article title',
     *          'article_translation_long_title': 'Test article long title',
     *          'article_translation_slug': 'test-article-slug',
     *          'article_translation_description': 'Test article description',
     *          'article_translation_lang': 'en'
     *      }
     *  ],
     *  'article_categories': [
     *      {
     *          'id': '22',
     *          'category_translations': [
     *              {
     *                  'category_translation_name': 'Coca-Cola',
     *                  'category_translation_slug': 'coca-cola-22',
     *                  'category_translation_lang': 'en'
     *              }
     *          ]
     *      },
     *      {
     *          'id': '23',
     *          'category_translations': [
     *              {
     *                  'category_translation_name': 'Facebook',
     *                  'category_translation_slug': 'facebook-23',
     *                  'category_translation_lang': 'en'
     *              }
     *          ]
     *      }
     *  ],
     *  'article_hashtags': [
     *      {
     *          'id': '2',
     *          'hashtag_name': 'phalcon'
     *      },
     *      {
     *          'id': '3',
     *          'hashtag_name': 'volt'
     *      }
     *  ],
     *  'article_author': {
     *      'user_first_name': 'John',
     *      'user_last_name': 'Doe',
     *      'user_email': 'john.doe@learning-phalcon.dev'
     *  }
     * }")
     */
    public function createAction()
    {
        try {
            $manager   = $this->getDI()->get('core_article_manager');

            if ($this->request->getHeader('CONTENT_TYPE') == 'application/json') {
                $data = $this->request->getJsonRawBody(true);
            } else {
                $data = $this->request->getPost();
            }

            if (count($data) == 0) {
                throw new \Exception('Please provide data', 400);
            }

            $st_inputData = array(
                'article_user_id' => $data['article_user_id'],
                'article_is_published' => $data['article_is_published'],
                'translations' => [
                    $data['article_translation_lang'] => [
                        'article_translation_short_title' => $data['article_translation_short_title'],
                        'article_translation_long_title' => $data['article_translation_long_title'],
                        'article_translation_description' => $data['article_translation_description'],
                        'article_translation_slug' => $data['article_translation_slug'],
                        'article_translation_lang' => $data['article_translation_lang'],
                    ],
                ],
                'categories' => $data['categories'],
                'hashtags' => $data['hashtags']
            );

            $st_output = $manager->restCreate($st_inputData);

            return $this->render($st_output);
        } catch (\Exception $e) {
            return $this->render([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
