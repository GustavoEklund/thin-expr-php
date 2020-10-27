<?php

namespace Expr;

use JsonException;

/**
 * Class Request
 * @package Expr
 */
class Request
{
    /**
     * Contém o conteúdo do corpo da requisição. O padrão é um objeto vazio.
     */
    private array $body;

    /**
     * Contém o host enviado pelo cabeçalho Host HTTP.
     */
    private string $port;

    /**
     * Contém o endereço ip remoto da requisição.
     */
    private string $ip;

    /**
     * Contém uma string correspondente ao método HTTP da requisição: GET, POST, PUT, etc.
     */
    private string $method;

    /**
     * Esta propriedade é um vetor contendo parâmetros de rota.
     */
    private array $params;

    /**
     * Contém o protocolo da requisição: http ou (requisições TLS) https.
     */
    private string $protocol;

    /**
     * Esta propriedade é um objeto contendo uma propriedade para cada parâmetro de busca.
     */
    private array $query;

    /**
     * Contém a rota chamada na requisição.
     */
    private string $route;

    public function __construct()
    {
        $php_input = file_get_contents('php://input');
		$request_url = explode('/', filter_var((string)@$_GET['url'], FILTER_SANITIZE_URL));

		if (empty($php_input)) {
			$post = $_POST;
		} else {
		    $php_input_array = [];

		    try {
                $php_input_array = json_decode($php_input, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException $json_exception) {}

            $post = array_merge($_POST, $php_input_array);
        }

		$this->setBody($post);
		$this->setPort((string)@$_SERVER['REMOTE_PORT']);
		$this->setIp((string)@$_SERVER['REMOTE_ADDR']);
		$this->setMethod((string)@$_SERVER['REQUEST_METHOD']);
        $this->setRoute((string)@$_GET['url']);
		$this->setParams((array)$request_url);
        $this->setProtocol((string)@$_SERVER['REQUEST_SCHEME']);
        unset($_REQUEST['url']);
        $this->setQuery($_REQUEST);
    }

    /**
     * Retorna o campo especificado do cabeçalho enviado na requisição HTTP.
     * @return mixed
     */
    public function getHeader()
    {
        return '';
    }

    /**
     * @param bool $sanitize
     * @return array
     */
    public function getBody(bool $sanitize = true): array
    {
        if (!$sanitize) {
            return $this->body;
        }

        $sanitized_body = [];

        foreach ($this->body as $key => $value) {
            $sanitized_body[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $sanitized_body;
    }

    public function setBody(array $body): void
    {
        $this->body = $body;
    }

    public function getPort(): string
    {
        return $this->port;
    }

    public function setPort(string $port): void
    {
        $this->port = $port;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function getProtocol(): string
    {
        return $this->protocol;
    }

    public function setProtocol(string $protocol): void
    {
        $this->protocol = $protocol;
    }

    public function getQuery(): array
    {
        return $this->query;
    }

    public function setQuery(array $query): void
    {
        $this->query = $query;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function setRoute(string $route): void
    {
        $this->route = $route;
    }
}
