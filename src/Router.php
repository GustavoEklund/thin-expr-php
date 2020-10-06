<?php

namespace Expr;

use JsonException;

/**
 * Class Router
 * @package Expr
 */
final class Router extends Route
{
    private bool $route_matched = false;

    /**
     * @param string $uri Uri para conversão de parâmetros em variáveis
     * @param array $action * Define o controller ou middleware
     * Se o método do middleware retornar falso ou null, $next não será executado.
     * Se o método retornar um valor válido, então é passado como terceiro parâmetro para o controller.
     * @return void
     * @throws JsonException
     */
	public function post(string $uri, ...$action): void
	{
		if ($this->route_matched || !isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
			return;
		} // if

        $this->route_matched = $this->add($uri, $action);
	} // post

    /**
     * @param string $uri Uri para conversão de parâmetros em variáveis
     * @param array $action * Define o controller ou middleware
     * Se o método do middleware retornar falso ou null, $next não será executado.
     * Se o método retornar um valor válido, então é passado como terceiro parâmetro para o controller.
     * @return void
     * @throws JsonException
     */
	public function get(string $uri, ...$action): void
	{
		if ($this->route_matched || !isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'GET') {
			return;
		} // if

        $this->route_matched = $this->add($uri, $action);
	} // get

    /**
     * @param string $uri Uri para conversão de parâmetros em variáveis
     * @param array $action * Define o controller ou middleware
     * Se o método do middleware retornar falso ou null, $next não será executado.
     * Se o método retornar um valor válido, então é passado como terceiro parâmetro para o controller.
     * @return void
     * @throws JsonException
     */
	public function put(string $uri, ...$action): void
	{
		if ($this->route_matched || !isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'PUT') {
			return;
		} // if

        $this->route_matched = $this->add($uri, $action);
	} // put

    /**
     * @param string $uri Uri para conversão de parâmetros em variáveis
     * @param array $action * Define o controller ou middleware
     * Se o método do middleware retornar falso ou null, $next não será executado.
     * Se o método retornar um valor válido, então é passado como terceiro parâmetro para o controller.
     * @return void
     * @throws JsonException
     */
	public function patch(string $uri, ...$action): void
	{
		if ($this->route_matched || !isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
			return;
		} // if

        $this->route_matched = $this->add($uri, $action);
	} // patch

    /**
     * @param string $uri Uri para conversão de parâmetros em variáveis
     * @param array $action * Define o controller ou middleware
     * Se o método do middleware retornar falso ou null, $next não será executado.
     * Se o método retornar um valor válido, então é passado como terceiro parâmetro para o controller.
     * @return void
     * @throws JsonException
     */
	public function delete(string $uri, ...$action): void
	{
		if ($this->route_matched || !isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
			return;
		} // if

        $this->route_matched = $this->add($uri, $action);
	} // put

    /**
     * Retorna uma rota assim que for executado.
     * @param string $uri Uri para conversão de parâmetros em variáveis
     * @param array $action * Define o controller ou middleware
     * Se o método do middleware retornar falso ou null, $next não será executado.
     * Se o método retornar um valor válido, então é passado como terceiro parâmetro para o controller.
     * @return void
     * @throws JsonException
     */
	public function any(string $uri, ...$action): void
	{
	    if ($this->route_matched) {
	        return;
        } // if

        $this->route_matched = $this->add($uri, $action);
	} // get
} // ClassRoutes
