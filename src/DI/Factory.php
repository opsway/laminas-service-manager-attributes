<?php

declare(strict_types=1);

namespace OpsWay\Laminas\ServiceManager\Attributes\DI;

//phpcs:ignore
use Attribute;

#[Attribute]
class Factory extends AbstractDIAttribute
{
    public function __construct(protected string $class)
    {
    }

    public function __invoke(string $keyClassName) : array
    {
        return [
            self::DEPENDENCIES => [
                self::FACTORIES => [
                    $keyClassName => $this->class,
                ],
            ],
        ];
    }

    public function factoryClass() : string
    {
        return $this->class;
    }
}
