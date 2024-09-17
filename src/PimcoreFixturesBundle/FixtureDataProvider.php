<?php

declare(strict_types=1);

namespace Instride\Bundle\PimcoreFixturesBundle;

use Instride\Bundle\PimcoreFixturesBundle\DataProvider\DataGeneratorInterface;

abstract class FixtureDataProvider extends Fixture
{
    public function __construct(private readonly DataGeneratorInterface $dataProvider) {}

    public function getDataProvider(): DataGeneratorInterface
    {
        return $this->dataProvider;
    }
}
