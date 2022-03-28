<?php

declare(strict_types=1);

namespace OpsWay\Laminas\ServiceManager\Attributes\DI;

//phpcs:ignore
use Attribute;

#[Attribute]
class ConfigFactory extends AbstractDIAttribute
{
    protected array $injectClasses = [];

    public function __construct(string ...$classNames)
    {
        foreach ($classNames as $className) {
            $this->injectClasses[] = $className;
        }
    }

    public function __invoke(string $keyClassName) : array
    {
        return [$this->factory => [$keyClassName => $this->injectClasses]];
    }
}
