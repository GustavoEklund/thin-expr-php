<?php

namespace Expr;

/**
 * Class Router
 * @package Expr
 */
final class Router
{
    private ExprBuilder $builder;

    /**
     * Router constructor.
     * @param ExprBuilder $builder
     */
	public function __construct(ExprBuilder $builder)
	{
        $this->builder = $builder;
	} // __construct

	/**
	 * @param string $uri Uri para conversão de parâmertros em variáveis
	 * @param array $action * Define o controller ou middleware
	 * Se o método do middleware retornar falso ou null, $next não será executado.
	 * Se o método retornar um valor válido, então é passado como terceiro parâmetro para o controller.
	 * @return void
	 */
	public function post(string $uri, ...$action): void
	{
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
			return;
		} // if

        (new Route($this->builder))->add($uri, $action);
	} // post

	/**
	 * @param string $uri Uri para conversão de parâmertros em variáveis
	 * @param array $action * Define o controller ou middleware
	 * Se o método do middleware retornar falso ou null, $next não será executado.
	 * Se o método retornar um valor válido, então é passado como terceiro parâmetro para o controller.
	 * @return void
	 */
	public function get(string $uri, ...$action): void
	{
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'GET') {
			return;
		} // if

        (new Route($this->builder))->add($uri, $action);
	} // get

	/**
	 * @param string $uri Uri para conversão de parâmertros em variáveis
	 * @param array $action * Define o controller ou middleware
	 * Se o método do middleware retornar falso ou null, $next não será executado.
	 * Se o método retornar um valor válido, então é passado como terceiro parâmetro para o controller.
	 * @return void
	 */
	public function put(string $uri, ...$action): void
	{
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
			return;
		} // if

        (new Route($this->builder))->add($uri, $action);
	} // put

	/**
	 * @param string $uri Uri para conversão de parâmertros em variáveis
	 * @param array $action * Define o controller ou middleware
	 * Se o método do middleware retornar falso ou null, $next não será executado.
	 * Se o método retornar um valor válido, então é passado como terceiro parâmetro para o controller.
	 * @return void
	 */
	public function patch(string $uri, ...$action): void
	{
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
			return;
		} // if

        (new Route($this->builder))->add($uri, $action);
	} // patch

	/**
	 * @param string $uri Uri para conversão de parâmertros em variáveis
	 * @param array $action * Define o controller ou middleware
	 * Se o método do middleware retornar falso ou null, $next não será executado.
	 * Se o método retornar um valor válido, então é passado como terceiro parâmetro para o controller.
	 * @return void
	 */
	public function delete(string $uri, ...$action): void
	{
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
			return;
		} // if

        (new Route($this->builder))->add($uri, $action);
	} // put

	/**
	 * Retorna uma rota assim que for executado.
	 * @param string $uri Uri para conversão de parâmertros em variáveis
	 * @param array $action * Define o controller ou middleware
	 * Se o método do middleware retornar falso ou null, $next não será executado.
	 * Se o método retornar um valor válido, então é passado como terceiro parâmetro para o controller.
	 * @return void
	 */
	public function any(string $uri, ...$action): void
	{
        (new Route($this->builder))->add($uri, $action);
	} // get
} // ClassRoutes
