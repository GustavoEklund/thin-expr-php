<?php

namespace Expr\Tests;

use Expr\ExprBuilder;
use Expr\Route;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class RouteTest extends TestCase
{
    private Route $route;
    
    public function assertPreConditions(): void
    {
        self::assertTrue(class_exists(ExprBuilder::class));
        self::assertTrue(class_exists(Route::class));
    } // assertPreConditions

    public function setUp(): void
    {
        $builder = (new ExprBuilder())
            ->setProductionMode(false)
            ->setControllersNamespace('Expr\\Tests\\Controllers\\')
            ->setPathToControllers(__DIR__.'/Controllers');
        
        $this->route = new Route($builder);
    } // setUp

    public function test_parsing_all_routes_returns_empty_array(): void
    {
        // Arrange
        $_GET['url'] = 'test';

        // Act
        $array = $this->route->parseRoute('*', $_GET['url']);

        // Assert
        self::assertEquals([], $array);
    } // assert_parsing_all_routes_returns_empty_array

    public function test_parsing_diferent_path_sizes_return_null(): void
    {
        // Arrange
        $_GET['url'] = 'home/test';

        // Act
        $response = $this->route->parseRoute('/home/test/all', $_GET['url']);

        // Assert
        self::assertNull($response);
    } // test_parsing_diferent_path_sizes_return_null

    public function test_parsing_non_exact_paths_return_null(): void
    {
        // Arrange
        $_GET['url'] = 'home/test';

        // Act
        $response = $this->route->parseRoute('/home/testing', $_GET['url']);

        // Assert
        self::assertNull($response);
    } // test_non_exact_paths_return_null

    public function test_parsing_converts_string_path_to_array(): void
    {
        // Arrange
        $_GET['url'] = 'home/test';

        // Act
        $array = $this->route->parseRoute('/home/test', $_GET['url']);

        // Assert
        self::assertArrayHasKey('home', $array);
        self::assertArrayHasKey('test', $array);
    } // test_parsing_converts_string_path_to_array

    public function test_parsing_path_bind_keys_to_parameters(): void
    {
        // Arrange
        $_GET['url'] = 'home/13/user/14';

        // Act
        $array = $this->route->parseRoute('/home/:id/user/:user_id', $_GET['url']);

        // Assert
        self::assertArrayHasKey('home', $array);
        self::assertArrayHasKey('id', $array);
        self::assertArrayHasKey('user', $array);
        self::assertArrayHasKey('user_id', $array);
        self::assertNull($array['home']);
        self::assertEquals('13', $array['id']);
        self::assertNull($array['user']);
        self::assertEquals('14', $array['user_id']);
    } // test_parsing_path_bind_keys_to_parameters

    public function test_add_route_without_get_url_throws_exception(): void
    {
        // Assert
        $this->expectException(RuntimeException::class);

        // Arrange
        unset($_GET['url']);

        // Act
        $this->route->add('/home', ['Testing@index']);
    } // test_add_route_without_get_url_throws_exception

    public function test_add_route_that_not_match_return_false(): void
    {
        // Arrange
        $_GET['url'] = 'home/test';

        // Act
        $response = $this->route->add('/casa/teste', ['Testing@index']);

        // Assert
        self::assertFalse($response);
    } // test_add_route_that_not_match_return_null

    public function test_add_route_that_returns_response_null_return_false(): void
    {
        // Arrange
        $_GET['url'] = 'home/test';

        // Act
        $response = $this->route->add('/home/test', ['Testing@returnNull']);

        // Assert
        self::assertFalse($response);
    } // test_add_route_that_returns_response_null_return_false

    public function test_add_route_prints_json_string_response_and_return_true(): void
    {
        // Assert
        $this->expectOutputString('{"error":false,"data":"index"}');

        // Arrange
        $_GET['url'] = 'home/test';

        // Act
        $response = $this->route->add('/home/test', ['Testing@index']);

        // Assert
        self::assertTrue($response);
    } // test_add_route_prints_json_string_response
} // RouteTest