<?php

declare(strict_types=1);

namespace OpsWay\Laminas\ServiceManager\Attributes\DI;

//phpcs:ignore
use Attribute;

#[Attribute]
class UseAsDelegatorFor extends AbstractDIAttribute
{
    public function __construct(protected string $class)
    {
    }

    public function __invoke(string $keyClassName) : array
    {
        return [
            self::DEPENDENCIES => [
                self::DELEGATORS => [
                    $this->class => [$keyClassName],
                ],
            ],
        ];
    }
}
