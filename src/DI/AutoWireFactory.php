<?php

declare(strict_types=1);

namespace OpsWay\Laminas\ServiceManager\Attributes\DI;

//phpcs:ignore
use Attribute;

#[Attribute]
class AutoWireFactory extends AbstractDIAttribute
{
    public function __invoke(string $keyClassName) : array
    {
        return [
            self::DEPENDENCIES => [
                self::FACTORIES => [
                    $keyClassName => $this->factory,
                ],
            ],
        ];
    }
}
