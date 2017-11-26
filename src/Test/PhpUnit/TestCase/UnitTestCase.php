<?php

namespace Kev\Test\PhpUnit\TestCase;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    protected function mock($className): MockInterface
    {
        return Mockery::mock($className);
    }

    protected function namedMock($name, $className): MockInterface
    {
        return Mockery::namedMock($name, $className);
    }
}
