<?php

declare(strict_types=1);

namespace OpsWay\Tests\Unit\Stubs;

//phpcs:disable
use OpsWay\Laminas\ServiceManager\Attributes\DI;

/**
 * @psalm-suppress all
 */
#[DI\AutoWireFactory]
class Example3Service
{
    public function __construct(private Example1Service $example1)
    {
    }
}
//phpcs:enable
