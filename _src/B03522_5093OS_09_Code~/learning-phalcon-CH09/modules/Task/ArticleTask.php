<?php
class ArticleTask extends BaseTask
{
    /**
     * @Description("Create a new article with the default data as it is defined in the manager->create() method")
     * @Example("php modules/cli.php article create")
     */
    public function createAction()
    {
        $manager = $this->getDI()->get('core_article_manager');

        try {
            $article = $manager->create(array(
                'article_user_id' => 12,
            ));
            $this->consoleLog(sprintf(
                "The article has been created. ID: %d",
                $article->getId()
            ));
        } catch (\Exception $e) {
            $this->consoleLog("There were some errors creating the article: ", "red");
            $this->consoleLog($e->getMessage(), "yellow");
            $errors = json_decode($e->getMessage(), true);

            if (is_array($errors)) {
                foreach ($errors as $error) {
                    $this->consoleLog("  - $error", "red");
                }
            } else {
                $this->consoleLog("  - $errors", "red");
            }
        }
    }

    /**
     * @Description("Create a new category with the default data as it is defined in the manager->create() method")
     * @Example("php modules/cli.php article createCategory")
     */
    public function createCategoryAction()
    {
        $manager = $this->getDI()->get('core_category_manager');

        try {
            $category = $manager->create(array());
            $this->consoleLog(sprintf(
                "The category has been created. ID: %d",
                $category->getId()
            ));
        } catch (\Exception $e) {
            $this->consoleLog("There were some errors creating the category: ", "red");
            $this->consoleLog($e->getMessage(), "yellow");
            $errors = json_decode($e->getMessage(), true);

            if (is_array($errors)) {
                foreach ($errors as $error) {
                    $this->consoleLog("  - $error", "red");
                }
            } else {
                $this->consoleLog("  - $errors", "red");
            }
        }
    }

    /**
     * @Description("Index all articles from MySQL to ES")
     * @Example("php modules/cli.php article esindex")
     */
    public function esindexAction()
    {
        $article_manager = $this->getDI()->get('core_article_manager');

        foreach ($article_manager->find() as $article) {
            try {
                $article_manager->esindex($article);
                $this->consoleLog("Article {$article->getId()} has been indexed");
            } catch (\Exception $e) {
                $this->consoleLog("Article {$article->getId()} has not been indexed. Reason: {$e->getMessage()}", "red");
            }
        }
    }

    public function essearchAction()
    {
        $client = $this->getDI()->get('elastic');
        $params['index'] = 'learningphalcon';
        $params['type']  = 'article';

//         $params['body']['query']['bool']['must'] = array(
//             array('match' => array('article_translation_short_title' => 'cars electric')),
//             array('match' => array('category_translation_slug' => 'logitech')),
//         );

        $queryResponse = $client->search($params);

        print_r($queryResponse);
    }
}
