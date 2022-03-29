<?php

declare(strict_types=1);

namespace OpsWay\Tests\Unit\Stubs;

//phpcs:disable
use OpsWay\Laminas\ServiceManager\Attributes\DI;

/**
 * @psalm-suppress all
 */
#[DI\AutoWireFactory]
class Example4Service
{
    public function __construct(
        #[DI\InjectService(Example2Service::class)] private $example3,
        private Example7ServiceInterface $example7
    ) {
    }
}
//phpcs:enable
