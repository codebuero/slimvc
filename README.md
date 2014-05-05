# Slim-MVC-Skeleton #
This is a skeleton project for using MVC pattern with the [Slim Framework](http://www.slimframework.com/). 

# Install
[Composer](http://getcomposer.com/) install,
```json
{
    "require": {
        "zacao/slim-mvc": "dev-master"
    }
}
```
*OR*

download the [latest code package](https://github.com/zacao/slim-mvc/archive/master.zip) from github directly to your local machine

# Folder Structure
 * app
   * controllers - controller classes
   * models - model classes
   * views - template files
   * routers - Slim routes group by feature, should be named as *feature_name.router.php*
   * middlewares - Slim customized middlware classes
   * etc - configuation file, e.g. config.php
 * lib - your customized lib classes against with the official composer classes in [PSR-4 standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md)
 * public - document root & the public assetic files, such as images, css and js
 * var - writable folder, such as log, cache, temp and so on

## app
Here should be the main folder which stores your own codes, such as controllers, models, views, middlewares and so on.
### routers
Slim routes group by feature, and names in *<feature_name>.router.php* format. 
differenct with the [Slim official example](http://docs.slimframework.com/#Routing-Overview), we using `<class_name>:<method_name>` like format string to define a router, against with uing Clouse in Slim officical doc.

`article.router.php`
```php
$app->get('/article/:id', 'ArticleController:get');
$app->delete('/article/:id', 'ArticleController:delete');
```
### controllers
Stores controller classes files which defined in router. It MUST be one class per file, and the filename should be same as the controller class name.

`IndexController.php`
```php
class IndexController extends ControllerAbstract
{
    public function index()
    {
        $data = array(
            'title' => 'It works!',
            'content' => 'Just have fun with the Slim in MVC way now!'
        );

        $this->render("index/index.phtml", $data);
    }
}
```
### etc
As the Slim configurate format, please refer to the original [Slim configuration doc](http://docs.slimframework.com/#Configuration-Overview)

`config.php`
```php
return array(
    'debug' => true,
    'templates.path' => BASE_DIR .'/app/views',
    'pdo' => array(
        'default' => array(
            'dsn' => 'mysql:host=localhost;dbname=test',
            'username' => 'root',
            'password' => '',
            'options' => array()
        ),
    ),
);
```
### middlewares
About the standard Slim middleware classes, Please refer to the original [Slim middleware doc](http://docs.slimframework.com/#Middleware-Overview)
### models
The model classes should be here. You can implement the model classes with any technology as you like.

`ArticleModel.php`
```php
class ArticleModel extends ModelAbstract
{
    public function delete($id)
    {
        // TODO related DML lines here
        $dbh = $this->getWriteConnection();

        return true;
    }
}
```
### views
Template files in default Slim format, Please refer to the original [Slim middleware doc](http://docs.slimframework.com/#View-Overview)

## lib
Put your customize classes files here, in this sample, we using PSR-4 as autoloading standard, please refer to `composer.json` and files under `lib` folder for detail.

`composer.json`
```json
"autoload": {
    "psr-4": {
        "": [
            "app/controllers",
            "app/models",
            "app/middlewares"
        ],
        "MyNamespace\\": "lib/"
    }
}
```
There are MyNamespace\Core\ControllerAbstract & MyNamespace\Core\ModelAbstract created under the lib folder for demonstration.

`ControllerAbstract.php`
```php
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
```
## public
Here is the *document root* (`.haccess` & `index.php`) and repository for public static assets, such as images, css and javascripts 

## var
Location for writable entires, such as logs, caches and temporary files
