<?php
use Crada\Apidoc\Builder;
use Crada\Apidoc\Exception;

class ApidocTask extends BaseTask
{
    /**
     * @Description("Build API Documentation")
     * @Example("php apps/cli.php apidoc generate")
     */
    public function generateAction($params = null)
    {
        $classes = [
            'App\Api\Controllers\ArticlesController',
            'App\Api\Controllers\HashtagsController',
            'App\Api\Controllers\CategoriesController',
            'App\Api\Controllers\UsersController',
        ];

        try {
            $builder = new Builder($classes, __DIR__.'/../../docs/api', 'Learning Phalcon API');
            $builder->generate();
            @exec("ln -s ".__DIR__."/../../docs/api ".__DIR__."/../../public/apidoc");
            $this->consoleLog('ok! : '.__DIR__.'/../../docs/api/index.html');
        } catch (Exception $e) {
            $this->consoleLog($e->getMessage(), 'red');
        }
    }
}
