<?php

declare(strict_types=1);

namespace OpsWay\Laminas\ServiceManager\Attributes\DI;

interface InvokableDIInterface
{
    public function __invoke(string $keyClassName) : array;
}
