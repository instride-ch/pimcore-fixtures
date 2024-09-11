<?php

declare(strict_types=1);

namespace Instride\Bundle\PimcoreFixturesBundle\Test\Attributes;

use Attribute;

#[Attribute]
final class FixtureGroups
{
    public array $groups;

    public function __construct(array $groups)
    {
        $this->groups = $groups;
    }
}
