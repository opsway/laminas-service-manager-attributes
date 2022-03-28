<?php

declare(strict_types=1);

namespace OpsWay\Laminas\ServiceManager\Attributes\DI;

//phpcs:ignore
use Attribute;

#[Attribute]
class InjectService extends AbstractDIAttribute
{
    public function __construct(protected string $class)
    {
    }

    public function __invoke(string $keyClassName) : array
    {
        return [$this->factory => [$keyClassName => [$this->class]]];
    }
}
