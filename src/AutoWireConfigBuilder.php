<?php

declare(strict_types=1);

namespace OpsWay\Laminas\ServiceManager\Attributes;

use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;

use function array_merge_recursive;
use function count;

class AutoWireConfigBuilder
{
    private array $configuration = [];

    /**
     * @psalm-suppress all
     */
    public function __construct(callable $attributeScanner)
    {
        foreach ($attributeScanner() as $keyClassName => $attributes) {
            $factory = DI\AbstractDIAttribute::DEFAULT_FACTORY;
            foreach ($attributes as $attribute) {
                if ($attribute instanceof DI\Factory) {
                    $factory = $attribute->factoryClass();
                } elseif ($attribute instanceof DI\AutoWireFactory && count($attributes) === 1) {
                    $factory = InvokableFactory::class;
                }
                $attribute->setFactory($factory);
                $this->configuration[] = $attribute($keyClassName);
            }
        }
        $this->configuration = array_merge_recursive(...$this->configuration);
    }

    /**
     * @psalm-suppress all
     */
    public function getDependencies() : array
    {
        return $this->configuration[DI\AbstractDIAttribute::DEPENDENCIES] ?? [];
    }

    /**
     * @psalm-suppress MixedReturnStatement
     */
    public function getConfig() : array
    {
        return [ConfigAbstractFactory::class => $this->configuration[ConfigAbstractFactory::class] ?? []];
    }

    public function __invoke() : array
    {
        return $this->configuration;
    }
}
