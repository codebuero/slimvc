# Slim in MVC #
This is a project about MVC Skeleton/Boilerplate for the [Slim Framework](http://www.slimframework.com/). 

## Install Composer

If you have not installed Composer, install it as following, 
<http://getcomposer.org/doc/00-intro.md#installation>

## Install the Application

After you install Composer, run below command from the directory in which you want to install.

(assumed you install composer as /usr/bin/composer globally, or please replace `composer` with `php composer.phar`),

```bash
  composer create-project zacao/slimvc [app-name]
```

Replace `[app-name]` with the directory name of your new application, and then do as below steps:
* Set your virtual host document root to the `public/` directory.
* Ensure folders under `var/` directory are writeable for your web server user, such as log, cache, and temp.

**OR**

your can download the [latest code package](https://github.com/zacao/slimvc/archive/master.zip) from github directly to your local machine

## Folder Structure
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

### app
Here should be the main folder which stores your own codes, such as controllers, models, views, middlewares and so on.

#### routers
Slim routes group by feature, and names in *<feature_name>.router.php* format. 
differenct with the [Slim official example](http://docs.slimframework.com/#Routing-Overview), we using `<optional-namespace>\<class_name>:<method_name>` format to define a router, against with uing Clouse in Slim official doc.

`article.router.php`
```php
$app->get('/article/:id', 'ArticleController:get');
$app->delete('/article/:id', 'ArticleController:delete');
```

> 1. router files are loaded & sorted in alphanumeric order, you can priority routers by proper file names, such as,
     0.default.router.php, 1.products.router.php (Thanks [Wout's comments](https://github.com/zacao/slimvc/issues/1) here)

> 2. you can also call contollers with namespace specified, e.g.
  ```php
  $app->get('/admin/article/:id', 'Admin\ArticleController:get');
  ```

#### controllers
Stores controller classes files which defined in router. It MUST be one class per file, and the filename should be same as the controller class name.

`IndexController.php`
```php
class IndexController extends Controller
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

#### etc
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

#### middlewares
About the standard Slim middleware classes, Please refer to the original [Slim middleware doc](http://docs.slimframework.com/#Middleware-Overview)

#### models
The model classes should be here. You can implement the model classes as you like.

`ArticleModel.php`
```php
class ArticleModel extends Model
{
    public function delete($id)
    {
        // TODO related DML lines here
        $dbh = $this->getWriteConnection();

        return true;
    }
}
```

#### views
Template files in default Slim format, Please refer to the original [Slim middleware doc](http://docs.slimframework.com/#View-Overview)

### lib
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
        "Slimvc\\": "lib/Slimvc"
    }
}
```
There are Slimvc\Core\Controller, Slimvc\Core\Model sample classes created under the lib folder.

`Controller.php`
```php
namespace Slimvc\Core;

abstract class Controller
{
    protected $appname = "default";

    protected function getApp()
    {
        return \Slim\Slim::getInstance($this->appname);
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
### public
Here is the *document root* (`.htaccess` & `index.php`) and repository for public static assets, such as images, css and javascripts 

### var
Location for writable entires, such as logs, caches and temporary files

## Packagist
<https://packagist.org/packages/zacao/slimvc>

## License
This project is released under the MIT public license.
