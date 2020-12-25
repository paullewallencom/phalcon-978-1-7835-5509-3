<?php
namespace App\Backoffice\Controllers;

class BaseController extends \App\Core\Controllers\BaseController
{
    public function afterExecuteRoute()
    {
        $this->buildAssets();
        $this->view->locales  = $this->getDI()->get('config')->i18n->locales->toArray();
        $this->view->identity = $this->getDI()->get('auth')->getIdentity();
    }

    /**
     * Build the collection of assets
     */
    private function buildAssets()
    {
        $assets_dir = __DIR__.'/../../../public/assets/';

        $this->assets
            ->collection('headerCss')
            ->addCss($assets_dir.'default/css/lp.backoffice.css')
            ->setTargetPath('assets/default/prod/backoffice.css')
            ->setTargetUri('../assets/default/prod/backoffice.css')
            ->join(true)
            ->addFilter(new \Phalcon\Assets\Filters\Cssmin());

        $this->assets
            ->collection('signin')
            ->addCss($assets_dir.'default/css/lp.backoffice.signin.css')
            ->setTargetPath('assets/default/prod/backoffice.signin.css')
            ->setTargetUri('../assets/default/prod/backoffice.signin.css')
            ->addFilter(new \Phalcon\Assets\Filters\Cssmin());

        $this->assets
            ->collection('footerJs')
            ->addJs($assets_dir.'default/bower_components/jquery/dist/jquery.min.js')
            ->addJs($assets_dir.'default/bower_components/bootstrap/dist/js/bootstrap.min.js')
            ->addJs($assets_dir.'default/js/lp.js')
            ->setTargetPath('assets/default/prod/backoffice.js')
            ->setTargetUri('../assets/default/prod/backoffice.js')
            ->join(true)
            ->addFilter(new \Phalcon\Assets\Filters\Jsmin());
    }
}
