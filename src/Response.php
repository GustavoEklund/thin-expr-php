<?php

namespace Expr;

use TypeError;
use JsonException;

/**
 * Class Response
 * @package Expr
 */
class Response
{
	/**
	 * @var array $enveloped_data
	 */
	private array $enveloped_data = [];

    /**
     * Retorna a resposta em formato JSON a partir de um array.
     *
     * @param array $value
     * @return string
     * @throws JsonException
     */
    public function json(array $value): string
    {
        return json_encode(
            array_merge(
                [
                    'error' => false,
                    'data' => $value,
                ],
                $this->enveloped_data
            ),
            JSON_THROW_ON_ERROR
        ); // json_encode
    } // append

    /**
     * Retorna a resposta em formato de texto plano.
     *
     * @param $value
     * @return false|string
     * @throws JsonException
     */
    public function send($value = ''): string
    {
        return json_encode(
            array_merge(
                [
                    'error' => false,
                    'data' => $value,
                ],
                $this->enveloped_data
            ),
            JSON_THROW_ON_ERROR
        ); // json_encode
    } // send

    /**
     * Define o código de status HTTP antes do retorno.
     *
     * @param int $code
     * @return $this
     */
    public function status(int $code): Response
    {
        http_response_code($code);
        return $this;
    } // status

	/**
	 * @param string $key
	 * @param $value
	 */
	public function append(string $key, $value): void
	{
		if (in_array($key, ['error', 'data'], true)) {
			throw new TypeError("\"$key\" cannot override default key responses.", 501);
		} // if

		$this->enveloped_data[$key] = $value;
	} // append

	/**
	 * @param string $header_name
	 * @param $value
	 */
	private function setHeader(string $header_name, $value): void
	{
		header("{$header_name}: $value");
	} // setHeader
} // Response
