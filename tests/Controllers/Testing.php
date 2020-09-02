<?php

namespace Expr\Tests\Controllers;

use JsonException;
use Expr\Request;
use Expr\Response;
use Expr\Controller;

/**
 * Class Testing only for testing purposes.
 * @package Tests\Controllers
 */
class Testing extends Controller
{
    /**
     * @param Request $request
     * @param Response $response
     * @return string
     * @throws JsonException
     */
    public function index(Request $request, Response $response): string
    {
        $params = $request->getParams();

        $response_text = $params['id'] ?? 'index';

        return $response->status(200)->send($response_text);
    } // index

    /**
     * @param Request $request
     * @param Response $response
     * @return string
     * @throws JsonException
     */
    public function find(Request $request, Response $response): string
    {
        return $response->status(200)->send('find');
    } // find

    /**
     * @param Request $request
     * @param Response $response
     * @return bool|null
     */
    public function returnNull(Request $request, Response $response): ?bool
    {
        return null;
    } // find
} // Testing