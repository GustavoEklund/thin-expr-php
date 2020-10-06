<?php

namespace Expr;

use RuntimeException;

/**
 * Class Route
 * @package Expr
 */
class Route extends Dispatch
{
    /**
     * Se o método do middleware retornar falso ou null, $next não será executado.
     * Se o método retornar um valor válido, então é passado como terceiro parâmetro para o controller.
     * @param string $uri Uri para conversão de parâmertros em variáveis
     * @param array $action Define um controller ou uma lista de ações a serem executados
     * @return bool
     */
	public function add(string $uri, array $action): bool
	{
        if (!isset($_GET['url'])) {
            throw new RuntimeException('Undefined "url" index on $_GET.');
        } // if

		$parsed_route = $this->parseRoute($uri, $_GET['url']);

		if ($parsed_route === null) {
			return false;
		} // if

		$response = null;
		$size = count($action);

        foreach ($action as $key => $action_item) {
            [$controller, $function] = explode('@', $action_item);

            $response = $this->request(
                $controller,
                $function,
                $parsed_route,
                $response,
            ); // request

            if ($response === null) {
                return false;
            } // if

            if ($size === ($key + 1)) {
                echo $response;
            } // if
        } // foreach

        return true;
	} // add

	/**
	 * @param string $path
	 * @param string $request_path
	 * @return array|null
	 */
	public function parseRoute(string $path, string $request_path): ?array
	{
		if ($path === '*') {
			return [];
		} // if

		$path_array = explode('/', ltrim($path, '/'));
		$request_path_array = explode('/', $request_path);

		if (count($path_array) !== count($request_path_array)) {
			return null;
		} // if

		$parsed_route = [];

		// Url de requisição é igual a esta rota?
		foreach ($path_array as $key => $item) {
			$new_key = ltrim($item, ':');

			// Se o primeiro caractere de path for ':' -> parâmetro de rota
			$parsed_route[$new_key] = (strpos($item, ':') === 0) ? $request_path_array[$key] : null;

			if ($parsed_route[$new_key] === null && $path_array[$key] !== $request_path_array[$key]) {
				return null;
			} // if
		} // foreach

		return $parsed_route;
	} // parseRoute
} // Route
