<?php

namespace Instride\Bundle\PimcoreFixturesBundle;

abstract class Fixture implements FixtureInterface
{

    public function getDependencies(): array
    {
        return [];
    }
}
