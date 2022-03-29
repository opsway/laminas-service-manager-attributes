<?php

declare(strict_types=1);

namespace OpsWay\Tests\Unit;

use OpsWay\Tests\Unit\Stubs\Example1Service;
use OpsWay\Tests\Unit\Stubs\Example2Service;
use OpsWay\Tests\Unit\Stubs\Example3Service;
use OpsWay\Tests\Unit\Stubs\Example4Service;
use OpsWay\Tests\Unit\Stubs\Example5Service;
use OpsWay\Tests\Unit\Stubs\Example6Service;
use OpsWay\Tests\Unit\Stubs\Example7ServiceInterface;
use OpsWay\Tests\Unit\Stubs\ExampleConfigCustomFactory;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;
use OpsWay\Laminas\ServiceManager\Attributes\AutoWireConfigBuilder;
use OpsWay\Laminas\ServiceManager\Attributes\DI\AttributeScanner;
use PHPUnit\Framework\TestCase;

use function array_merge;

class AutoWireConfigBuilderTest extends TestCase
{
    public function testBuild(): void
    {
        /*
         * scanner

         * @var $autoload ClassLoader


        $autoload = include 'vendor/autoload.php';
        $classToScan = array_values(array_filter($autoload->getClassMap(), fn($className, $dir) => str_contains(haystack: $className, needle: 'OpsWay\Tests\Unit\Stubs')));
        $foundAttributes = [];
        foreach ($classToScan as $class) {
            $attrs = (new \ReflectionClass($class))->getAttributes(AbstractDIAttribute::class, ReflectionAttribute::IS_INSTANCEOF);
            if (!empty($attrs)) {
                $foundAttributes[$class] = array_map(
                    callback: static fn(ReflectionAttribute $rAttr) => $rAttr->newInstance(),
                    array: $attrs);
            }
        }
         --scanner */

        $builder            = new AutoWireConfigBuilder(new AttributeScanner('OpsWay\Tests\Unit\Stubs'));
        $dependencies       = $builder->getDependencies();
        $config             = $builder->getConfig();
        $resultDependencies = [
            'factories' => [
                Example1Service::class => InvokableFactory::class,
                Example2Service::class => InvokableFactory::class,
                Example3Service::class => ConfigAbstractFactory::class,
                Example4Service::class => ConfigAbstractFactory::class,
                Example5Service::class => ExampleConfigCustomFactory::class,
            ],
            'aliases'   => [
                Example6Service::class => Example1Service::class,
            ],
            'shared'    => [
                Example5Service::class => true,
            ],
        ];

        $resultConfig = [
            ConfigAbstractFactory::class => [
                Example3Service::class => [
                    Example1Service::class,
                ],
                Example4Service::class => [
                    Example2Service::class,
                    Example7ServiceInterface::class,
                ],
            ],
        ];

        $all       = $builder();
        $allResult = array_merge(
            ['dependencies' => $resultDependencies],
            $resultConfig,
            [
                ExampleConfigCustomFactory::class => [
                    Example5Service::class => [
                        Example2Service::class,
                        Example6Service::class,
                    ],
                ],
            ]
        );
        $this->assertSame($resultDependencies, $dependencies);
        $this->assertSame($resultConfig, $config);
        $this->assertSame($allResult, $all);
    }
}
