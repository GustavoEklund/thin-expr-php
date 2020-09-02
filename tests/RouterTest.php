<?php

namespace Expr\Tests;

use Expr\ExprBuilder;
use Expr\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;

    public function assertPreConditions(): void
    {
        self::assertTrue(class_exists(ExprBuilder::class));
        self::assertTrue(class_exists(Router::class));
    } // assertPreConditions

    public function setUp(): void
    {
        $builder = (new ExprBuilder())
            ->setProductionMode(false)
            ->setControllersNamespace('Expr\\Tests\\Controllers\\')
            ->setPathToControllers(__DIR__.'/Controllers');

        $this->router = new Router($builder);
    } // setUp

    public function test_post_method_run_only_on_post_requests(): void
    {
        // Arrange Assert
        $this->expectOutputString('{"error":false,"data":"index"}');

        $_GET['url'] = 'home/test';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        // Act
        $this->router->get('/home/test', 'Testing@find');
        $this->router->put('/home/test', 'Testing@find');
        $this->router->patch('/home/test', 'Testing@find');
        $this->router->delete('/home/test', 'Testing@find');
        $this->router->post('/home/test', 'Testing@index');
    } // test_post_method_run_only_on_post_requests

    public function test_get_method_run_only_on_get_requests(): void
    {
        // Arrange Assert
        $this->expectOutputString('{"error":false,"data":"index"}');

        $_GET['url'] = 'home/test';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        // Act
        $this->router->post('/home/test', 'Testing@find');
        $this->router->put('/home/test', 'Testing@find');
        $this->router->patch('/home/test', 'Testing@find');
        $this->router->delete('/home/test', 'Testing@find');
        $this->router->get('/home/test', 'Testing@index');
    } // test_post_method_run_only_on_post_requests

    public function test_put_method_run_only_on_put_requests(): void
    {
        // Arrange Assert
        $this->expectOutputString('{"error":false,"data":"index"}');

        $_GET['url'] = 'home/test';
        $_SERVER['REQUEST_METHOD'] = 'PUT';

        // Act
        $this->router->post('/home/test', 'Testing@find');
        $this->router->get('/home/test', 'Testing@find');
        $this->router->patch('/home/test', 'Testing@find');
        $this->router->delete('/home/test', 'Testing@find');
        $this->router->put('/home/test', 'Testing@index');
    } // test_post_method_run_only_on_post_requests

    public function test_patch_method_run_only_on_patch_requests(): void
    {
        // Arrange Assert
        $this->expectOutputString('{"error":false,"data":"index"}');

        $_GET['url'] = 'home/test';
        $_SERVER['REQUEST_METHOD'] = 'PATCH';

        // Act
        $this->router->post('/home/test', 'Testing@find');
        $this->router->get('/home/test', 'Testing@find');
        $this->router->put('/home/test', 'Testing@find');
        $this->router->delete('/home/test', 'Testing@find');
        $this->router->patch('/home/test', 'Testing@index');
    } // test_post_method_run_only_on_post_requests

    public function test_delete_method_run_only_on_delete_requests(): void
    {
        // Arrange Assert
        $this->expectOutputString('{"error":false,"data":"index"}');

        $_GET['url'] = 'home/test';
        $_SERVER['REQUEST_METHOD'] = 'DELETE';

        // Act
        $this->router->post('/home/test', 'Testing@find');
        $this->router->get('/home/test', 'Testing@find');
        $this->router->put('/home/test', 'Testing@find');
        $this->router->patch('/home/test', 'Testing@find');
        $this->router->delete('/home/test', 'Testing@index');
    } // test_post_method_run_only_on_post_requests

    public function test_route_prameters_can_be_used(): void
    {
        // Arrange Assert
        $this->expectOutputString('{"error":false,"data":"7"}');

        $_GET['url'] = 'home/test/7';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        // Act
        $this->router->get('/home/test/:id', 'Testing@index');
    } // test_route_prameters_can_be_used

    public function test_only_exact_url_match_run(): void
    {
        // Arrange Assert
        $this->expectOutputString('{"error":false,"data":"any_id"}');

        $_GET['url'] = 'home/test/any_id';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        // Act
        $this->router->get('/home/test/:id/all', 'Testing@index');
        $this->router->get('/home/test/all', 'Testing@index');
        $this->router->get('/home/test/:id', 'Testing@index');
        $this->router->get('/home/test', 'Testing@index');
        $this->router->post('/home/test/:id', 'Testing@index');
    } // test_match_precedence

    public function test_only_one_route_each_request(): void
    {
        $this->expectOutputString('{"error":false,"data":"7"}');

        $_GET['url'] = 'home/test/7';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->router->get('/home/test/:id', 'Testing@index');
        $this->router->get('/home/test/:id', 'Testing@index');
        $this->router->post('/home/test/:id', 'Testing@index');
    } // test_only_one_route_each_request
} // RouterTest