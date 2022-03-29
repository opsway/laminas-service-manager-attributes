<?php

declare(strict_types=1);

namespace OpsWay\Tests\Unit\Stubs;

//phpcs:disable
use OpsWay\Laminas\ServiceManager\Attributes\DI;

/**
 * @psalm-suppress all
 */
#[DI\Factory(ExampleConfigCustomFactory::class)]
#[DI\ConfigFactory(Example2Service::class, Example6Service::class)]
#[DI\Shared(true)]
class Example5Service
{
    public function __construct(private $example2, private $example1)
    {
    }
}
//phpcs:enable
