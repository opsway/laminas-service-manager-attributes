<?php

declare(strict_types=1);

namespace OpsWay\Laminas\ServiceManager\Attributes\DI;

use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;

abstract class AbstractDIAttribute implements InvokableDIInterface
{
    public const DEPENDENCIES = 'dependencies';
    public const FACTORIES    = 'factories';
    public const ALIASES      = 'aliases';
    public const DELEGATORS   = 'delegators';
    public const SHARED       = 'shared';

    public const DEFAULT_FACTORY = ConfigAbstractFactory::class;

    protected string $factory = self::DEFAULT_FACTORY;

    abstract public function __invoke(string $keyClassName) : array;

    public function setFactory(string $factory) : void
    {
        $this->factory = $factory;
    }
}
