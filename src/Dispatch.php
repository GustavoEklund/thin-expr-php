<?php

namespace Expr;

use Error;
use JsonException;
use TypeError;
use Exception;
use PDOException;

/**
 * Class Dispatch
 * @package Expr
 */
class Dispatch
{
	private string $method;
	private $controller;
	private ExprBuilder $builder;

    public function __construct(ExprBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param string $controller
     * @param string $function
     * @param array $params
     * @param mixed $resource
     * @return mixed
     */
	public function request(string $controller, string $function, array $params, $resource)
    {
		try {
			$request = new Request();
			$response = new Response();

			$request->setParams($params);

			$this->setController($controller, $this->builder->getPathToControllers());
			$this->setMethod($function);

			// Execute o método contido no Controller ([Controller, método], [parâmetros do método])
			return call_user_func(
			    [$this->getController(), $this->getMethod()],
                $request,
                $response,
                $this->builder->getResource(),
                $resource,
            );
		} catch (PDOException $pdo_exception) {
			http_response_code(503);

            if ($this->builder->isProductionMode()) {
                $error_message = "Erro código [{$pdo_exception->getCode()} - {$pdo_exception->getLine()}]";
            } else {
                $error_message = "Erro código [{$pdo_exception->getCode()} - {$pdo_exception->getLine()} - {$pdo_exception}]";
            }

            $error_date = date('[Y-m-d H:i:s]');
            $php_input = file_get_contents('php://input');

            if (empty($php_input)) {
                $post = $_POST;
            } else {
                $php_input_array = [];

                try {
                    $php_input_array = json_decode($php_input, true, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $json_exception) {}

                $post = array_merge($_POST, $php_input_array);
            }

            $body = http_build_query($post);

            $log_message = "{$error_date} {$pdo_exception}\n";
            $log_message .= 'REQUEST_METHOD: '.@$_SERVER['REQUEST_METHOD']."\n";
            $log_message .= 'REMOTE_ADDR: '.@$_SERVER['REMOTE_ADDR']."\n";
            $log_message .= 'SERVER_NAME: '.@$_SERVER['SERVER_NAME']."\n";
            $log_message .= 'REQUEST_URI: '.@$_SERVER['REQUEST_URI']."\n";
            $log_message .= 'PATH_INFO: '.@$_SERVER['PATH_INFO']."\n";
            $log_message .= "BODY: {$body}\n\n\n";

            error_log($log_message, 3, './log.txt');

            $error_message = preg_replace('/[\n\r\\\\"]/', ' ', $error_message);

            return '{"error":{"code":'.$pdo_exception->getCode().',"message":"'.$error_message.'"},"data":null}';
		} catch (Exception $exception) {
			if ($exception->getCode()) {
			    http_response_code($exception->getCode());
			} else {
			   http_response_code(501);
			}

            if ($this->builder->isProductionMode()) {
                $error_message = $exception->getMessage();
            } else {
                $error_message = $exception;
            }

            $error_date = date('[Y-m-d H:i:s]');
            $php_input = file_get_contents('php://input');

            if (empty($php_input)) {
                $post = $_POST;
            } else {
                $php_input_array = [];

                try {
                    $php_input_array = json_decode($php_input, true, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $json_exception) {}

                $post = array_merge($_POST, $php_input_array);
            }

            $body = http_build_query($post);

            $log_message = "{$error_date} {$exception}\n";
            $log_message .= 'REQUEST_METHOD: '.@$_SERVER['REQUEST_METHOD']."\n";
            $log_message .= 'REMOTE_ADDR: '.@$_SERVER['REMOTE_ADDR']."\n";
            $log_message .= 'SERVER_NAME: '.@$_SERVER['SERVER_NAME']."\n";
            $log_message .= 'REQUEST_URI: '.@$_SERVER['REQUEST_URI']."\n";
            $log_message .= 'PATH_INFO: '.@$_SERVER['PATH_INFO']."\n";
            $log_message .= "BODY: {$body}\n\n\n";

            error_log($log_message, 3, './log.txt');

            $error_message = preg_replace('/[\n\r\\\\"]/', ' ', $error_message);

            return '{"error":{"code":'.$exception->getCode().',"message":"'.$error_message.'"},"data":null}';
		} catch (Error $error) {
             if ($error->getCode()) {
                 http_response_code($error->getCode());
             } else {
                http_response_code(501);
             }

            if ($this->builder->isProductionMode()) {
                $error_message = $error->getMessage();
            } else {
                $error_message = $error;
            }

            $error_date = date('[Y-m-d H:i:s]');
            $php_input = file_get_contents('php://input');

            if (empty($php_input)) {
                $post = $_POST;
            } else {
                $php_input_array = [];

                try {
                    $php_input_array = json_decode($php_input, true, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $json_exception) {}

                $post = array_merge($_POST, $php_input_array);
            }

            $body = http_build_query($post);

            $log_message = "{$error_date} {$error}\n";
            $log_message .= 'REQUEST_METHOD: '.@$_SERVER['REQUEST_METHOD']."\n";
            $log_message .= 'REMOTE_ADDR: '.@$_SERVER['REMOTE_ADDR']."\n";
            $log_message .= 'SERVER_NAME: '.@$_SERVER['SERVER_NAME']."\n";
            $log_message .= 'REQUEST_URI: '.@$_SERVER['REQUEST_URI']."\n";
            $log_message .= 'PATH_INFO: '.@$_SERVER['PATH_INFO']."\n";
            $log_message .= "BODY: {$body}\n\n\n";

            error_log($log_message, 3, './log.txt');

            $error_message = preg_replace('/[\n\r\\\\"]/', ' ', $error_message);

            return '{"error":{"code":'.$error->getCode().',"message":"'.$error_message.'"},"data":null}';
        }
	}

    /** @return mixed */
    public function getController()
    {
        return $this->controller;
    }

    public function setController(string $controller, string $path): void
    {
        $autoload_controller = "{$this->builder->getControllersNamespace()}{$controller}";

        if (!file_exists("{$path}/{$controller}.php")) {
            throw new TypeError("The file '{$controller}.php' doesn't exist on Controllers folder.'", 501);
        }

        if (!class_exists($autoload_controller, true)) {
            throw new TypeError("The class '{$controller}' doesn't exist on {$autoload_controller}.'", 501);
        }

        // Instancia o Controller requisitado na url
        $this->controller = new $autoload_controller((object)[]);
    }

    private function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        if (!method_exists($this->getController(), $method)) {
			$class_name = get_class($this->getController());
			throw new TypeError("The method '{$method}' doesn't exist on controller {$class_name}.", 501);
		}

		// Atribui o índice 1 da url ao método
		$this->method = $method;
	}
}
