<?php

namespace Instride\PimcoreFixturesBundle;

abstract class Fixture implements FixtureInterface
{

    public function getDependencies(): array
    {
        return [];
    }
}
