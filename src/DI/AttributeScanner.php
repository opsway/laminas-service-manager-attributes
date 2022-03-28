<?php

declare(strict_types=1);

namespace OpsWay\Laminas\ServiceManager\Attributes\DI;

use Composer\Autoload\ClassLoader;
use OpsWay\Laminas\ServiceManager\Attributes\DI;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;

use function array_filter;
use function array_keys;
use function array_map;
use function array_merge_recursive;
use function class_exists;
use function count;
use function end;
use function interface_exists;
use function str_contains;

use const ARRAY_FILTER_USE_KEY;

class AttributeScanner
{
    public function __construct(private string $namespace)
    {
    }

    /**
     * @throws ReflectionException
     * @psalm-suppress all
     */
    public function __invoke() : array
    {
        /** @var ClassLoader $autoload */
        $autoload    = include 'vendor/autoload.php';
        $classToScan = array_keys(
            array_filter(
                $autoload->getClassMap(),
                fn($className) => str_contains($className, $this->namespace),
                ARRAY_FILTER_USE_KEY
            )
        );

        $foundAttributes            = [];
        $foundConstructorAttributes = [];

        foreach ($classToScan as $class) {
            $reflection = new ReflectionClass($class);
            $attrs      = $reflection->getAttributes(DI\AbstractDIAttribute::class, ReflectionAttribute::IS_INSTANCEOF);

            if (! empty($attrs)) {
                $foundAttributes[$class] = array_map(
                    static fn(ReflectionAttribute $rAttr) => $rAttr->newInstance(),
                    $attrs
                );
            }

            // constructor params attrs parser
            $autoWireAttrs = $reflection->getAttributes(
                DI\AutoWireFactory::class,
                ReflectionAttribute::IS_INSTANCEOF
            );
            if (! empty($autoWireAttrs)) {
                $constructorParams = $reflection->getConstructor()
                    ? $reflection->getConstructor()->getParameters()
                    : [];
                $constructorAttrs  = [];
                foreach ($constructorParams as $constructorParam) {
                    $constructorReflectionAttrs = $constructorParam
                        ->getAttributes(DI\InjectService::class, ReflectionAttribute::IS_INSTANCEOF);
                    if (count($constructorReflectionAttrs) === 1) {
                        $constructorAttrs[] = (end($constructorReflectionAttrs))->newInstance();
                    } elseif ($constructorParam->hasType()) {
                        $constructorParamTypeClassName = $constructorParam->getType()->getName();
                        if (
                            class_exists($constructorParamTypeClassName)
                            || interface_exists($constructorParamTypeClassName)
                        ) {
                            $constructorAttrs[] = new DI\InjectService($constructorParamTypeClassName);
                        }
                    }
                }

                if (! empty($constructorAttrs)) {
                    $foundConstructorAttributes[$class] = $constructorAttrs;
                }
            }
        }

        return array_merge_recursive($foundAttributes, $foundConstructorAttributes);
    }
}
