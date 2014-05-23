<?php
namespace Slimvc\Core;

abstract class Controller
{
    protected $appname = "default";

    /**
     * Gets the Slim Application instance
     *
     * @return \Slim\Slim
     */
    protected function getApp()
    {
        return \Slim\Slim::getInstance($this->appname);
    }

    /**
     * Gets the configuration instance of the related Slim Application
     *
     * @return array
     */
    protected function getConfig()
    {
        return $this->getApp()->container['settings'];
    }

    /**
     * Render a template
     *
     * @param  string $template The name of the template passed into the view's render() method
     * @param  array  $data     Associative array of data made available to the view
     * @param  int    $status   The HTTP response status code to use (optional)
     */
    protected function render($template, $data = array(), $status = null)
    {
        $this->getApp()->render($template, $data, $status);
    }
}