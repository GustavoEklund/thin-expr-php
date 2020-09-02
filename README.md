# expr-php

## Getting started

### Installation

expr-php utilizes [Composer](https://getcomposer.org/) to manage its dependencies. So, before using expr-php, make sure you have Composer installed on your machine.

If the requirements are right, go ahead inside your project folder in your terminal and type the following command:

```bash
    composer init -y
    composer require thenrise/expr-php:dev-master
```
### Configuration

All you need to start using is create an `index.php` file in your project. For this tutorial we'll have the following directory structure:

```text
expr-php-tutorial
|-- src
|   `-- Controllers
|-- vendor (created by composer)
|   `-- ...
|-- .htaccess
|-- composer.json (created by composer)
|-- composer.lock (created by composer)
|-- index.php
```

Inside your `composer.json` file make sure to configure the autoload propety, add the key `"autoload"` if necessary:

```json
"autoload": {
    "psr-4": {
        "Controllers\\": "./src/Controllers/"
    }
}
```

Now, make sure your `.htaccess` file's configured to change url string into a `url` to the `$_GET` superglobal:

```htaccess
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```

Inside your `index.php`, first you need to require the autoloader, and then import two classes: `Expr\ExprBuilder` and `Expr\Router`. After that you can start the configuration that looks like: 

```php
<?php # index.php

require_once('./vendor/autoload.php');

use Expr\ExprBuilder;
use Expr\Router;

$builder = (new ExprBuilder())
	->setControllersNamespace('Controllers\\\\')
	->setPathToControllers(__DIR__.'/src/Controllers')
	->setProductionMode(false);

$router = new Router($builder);
```

### Routing

All expr-php routes are defined in your controllers files, which are located in the controllers directory. These files are loaded by the framework using the `setControllersNamespace()` and `setPathControllers()`.

There are some methods to listen to routes using the http verbs:

```php
$router->get(string $path, string ...$actions);
$router->post(string $path, string ...$actions);
$router->put(string $path, string ...$actions);
$router->patch(string $path, string ...$actions);
$router->delete(string $path, string ...$actions);
$router->any(string $path, string ...$actions);
```

For example, let's use our last code and create our fisrt route:

```php
<?php # index.php

require_once('./vendor/autoload.php');

use Expr\ExprBuilder;
use Expr\Router;

$builder = (new ExprBuilder())
	->setControllersNamespace('Controllers\\\\')
	->setPathToControllers(__DIR__.'/src/Controllers')
	->setProductionMode(false);

$router = new Router($builder);

$router->get('/home', 'HomeController@index');
```

Now we can create our first controller to be accessed by our route. So let's create a file `HomeController.php` inside `src/Controllers/` folder:

```php
<?php # src/Controllers/HomeController.php

namespace Controllers;

use Expr\Request;
use Expr\Response;

class HomeController
{
    public function index(Request $request, Response $response): string
    {
        return $response->status(200)->send('Hello, World');
    }
}
```

Accessing on the browser the url `http://localhost/expr-php-tutorial/home` should output the following:

```json
{"error":false,"data":"Hello, World!"}
```

### Route Params

Sometimes you will need to capture segments of the URI within your route. For example, you may need to capture a user's ID from the URL. You may do so by defining route parameters:

```php
# index.php
$router->get('/user/:id', 'UserController@index');
```
```php
    # src/Controllers/UserController.php
    public function index(Request $request, Response $response): string
    {
        $params = $request->getParams();

        return $response->status(200)->send($params['id']);
    } // index
```

### Request Body

Sometimes you will need to capture the body content within your request. You may do so by getting the body params:

```json
# XHTTPRequest
{
  "name": "Gustavo Eklund",
  "type": "admin" 
}
```
```php
# index.php
$router->post('/user', 'UserController@create');
```
```php
    # src/Controllers/UserController.php
    public function create(Request $request, Response $response): string
    {
        $body = $request->getBody();

        return $response->status(200)->send("{$body['name']} is an {$body['type']}");
    } // index
```
