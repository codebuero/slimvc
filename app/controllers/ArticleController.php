<?php
use MyNamespace\Core\ControllerAbstract;

class ArticleController extends ControllerAbstract
{
    public function get($id)
    {
        var_dump(__METHOD__);
        $config = $this->getConfig();

        $model = new ArticleModel($config);
        $ret = $model->getById($id);

        var_dump($ret);
    }

    public function delete($id)
    {
        var_dump(__METHOD__);
        $config = $this->getConfig();

        $model = new ArticleModel($config);
        $ret = $model->delete($id);

        var_dump($ret);
    }
}