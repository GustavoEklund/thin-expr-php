<?php

namespace Expr\Tests;

use TypeError;
use Expr\ExprBuilder;
use PHPUnit\Framework\TestCase;

class ExprBuilderTest extends TestCase
{
    private ExprBuilder $builder;

    public function assertPreConditions(): void
    {
        self::assertTrue(class_exists(ExprBuilder::class));
    } // assertPreConditions

    public function setUp(): void
    {
        $this->builder = new ExprBuilder();
    } // setUp

    public function test_can_set_path_to_controller(): void
    {
        $this->builder->setPathToControllers(__DIR__);
        self::assertEquals(__DIR__, $this->builder->getPathToControllers());
    } // test_can_set_path_to_controller

    public function test_assert_invalid_path_throw_error(): void
    {
        $this->expectException(TypeError::class);
        $this->builder->setPathToControllers('/any/invalid/directory');
    } // test_assert_invalid_path_throw_error

    public function test_can_set_controllers_namespace(): void
    {
        $this->builder->setControllersNamespace('Expr\\');
        self::assertEquals('Expr\\', $this->builder->getControllersNamespace());
    } // test_can_set_controllers_namespace

    public function test_can_set_production_mode(): void
    {
        $this->builder->setProductionMode(true);
        self::assertTrue($this->builder->isProductionMode());

        $this->builder->setProductionMode(false);
        self::assertFalse($this->builder->isProductionMode());
    } // test_can_set_production_mode

    public function test_can_set_resource(): void
    {
        $this->builder->setResource(['anything' => true]);
        self::assertArrayHasKey('anything', $this->builder->getResource());

        $this->builder->setResource('test');
        self::assertEquals('test', $this->builder->getResource());
    } // test_can_set_resource
} // ExprBuilderTest