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
}
