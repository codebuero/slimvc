<?php
use MyNamespace\Core\ControllerAbstract;

class IndexController extends ControllerAbstract
{
    public function index()
    {
        var_dump(__METHOD__);

        $data = array(
            'title' => 'It works!',
            'content' => 'Just have fun with the Slim in MVC way now!'
        );

        $this->render("index/index.phtml", $data);
    }
}