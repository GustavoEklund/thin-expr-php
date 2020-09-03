<?php

namespace Expr;

use TypeError;

/**
 * Class ExprBuilder
 * @package Expr
 */
class ExprBuilder
{
    private string $path_to_controllers;
    private string $controllers_namespace;
    private bool $production_mode;

    /**
     * Any resource, configuration or dependency you need to inject inside the controllers
     * @var mixed $resource
     */
    private $resource;

    /**
     * Builder constructor.
     */
    public function __construct()
    {
        $this->path_to_controllers = '../../';
        $this->controllers_namespace = 'Controllers\\';
        $this->production_mode = false;
        $this->resource = null;
    } // __construct

    /**
     * @return string
     */
    public function getPathToControllers(): string
    {
        return $this->path_to_controllers;
    } // getPathToControllers

    /**
     * @param string $path
     * @return ExprBuilder
     * @throws TypeError
     */
    public function setPathToControllers(string $path): ExprBuilder
    {
        if (!is_dir($path)) {
            throw new TypeError('The path to controllers must be a valid directory.');
        } // if

        $this->path_to_controllers = $path;
        return $this;
    } // setPathToControllers

    /**
     * @return string
     */
    public function getControllersNamespace(): string
    {
        return $this->controllers_namespace;
    } // getControllersNamespace

    /**
     * @param string $namespace
     * @return ExprBuilder
     */
    public function setControllersNamespace(string $namespace): ExprBuilder
    {
        $this->controllers_namespace = $namespace;
        return $this;
    } // setControllersNamespace

    /**
     * @return bool
     */
    public function isProductionMode(): bool
    {
        return $this->production_mode;
    } // isProductionMode

    /**
     * @param bool $mode
     * @return ExprBuilder
     */
    public function setProductionMode(bool $mode): ExprBuilder
    {
        $this->production_mode = $mode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param mixed $resource
     * @return ExprBuilder
     */
    public function setResource($resource): ExprBuilder
    {
        $this->resource = $resource;
        return $this;
    } // setProductionMode
} // Builder