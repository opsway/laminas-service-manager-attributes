<?php

declare(strict_types=1);

namespace OpsWay\Tests\Unit\Stubs;

use Laminas\ServiceManager\Factory\InvokableFactory;
use OpsWay\Laminas\ServiceManager\Attributes\DI;

#[DI\Factory(InvokableFactory::class)]
#[DI\AliasTo(Example6Service::class)]
class Example1Service implements Example6Service
{
}
