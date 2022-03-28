<?php

declare(strict_types=1);

namespace OpsWay\Laminas\ServiceManager\Attributes\DI;

//phpcs:ignore
use Attribute;

#[Attribute]
class AliasTo extends AbstractDIAttribute
{
    public function __construct(protected string $class)
    {
    }

    public function __invoke(string $keyClassName) : array
    {
        return [
            self::DEPENDENCIES => [
                self::ALIASES => [
                    $this->class => $keyClassName,
                ],
            ],
        ];
    }

    public function aliasTo() : string
    {
        return $this->class;
    }
}
