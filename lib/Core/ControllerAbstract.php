<?php
namespace MyNamespace\Core;

abstract class ControllerAbstract
{
    protected function getApp()
    {
        return \Slim\Slim::getInstance();
    }

    protected function getConfig()
    {
        return $this->getApp()->container['settings'];
    }

    protected function render($template, $data = array(), $status = null)
    {
        $this->getApp()->render($template, $data, $status);
    }
}