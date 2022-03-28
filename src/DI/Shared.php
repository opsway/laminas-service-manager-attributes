<?php

declare(strict_types=1);

namespace OpsWay\Laminas\ServiceManager\Attributes\DI;

//phpcs:ignore
use Attribute;

#[Attribute]
class Shared extends AbstractDIAttribute
{
    public function __construct(private bool $flag)
    {
    }

    public function __invoke(string $keyClassName) : array
    {
        return [
            self::DEPENDENCIES => [
                self::SHARED => [
                    $keyClassName => $this->flag,
                ],
            ],
        ];
    }
}
