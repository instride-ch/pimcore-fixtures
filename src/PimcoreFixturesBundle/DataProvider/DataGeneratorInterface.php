<?php

declare(strict_types=1);

namespace Instride\Bundle\PimcoreFixturesBundle\DataProvider;


interface DataGeneratorInterface
{
    public function generate(string $class, int $amount, array $static_values = []): array;
}
