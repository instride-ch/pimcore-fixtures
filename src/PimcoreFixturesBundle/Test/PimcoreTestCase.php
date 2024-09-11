<?php

declare(strict_types=1);

namespace Instride\Bundle\PimcoreFixturesBundle\Test;

use Instride\Bundle\PimcoreFixturesBundle\Executor\ObjectFixturesExecutor;
use Instride\Bundle\PimcoreFixturesBundle\Loader\ObjectFixturesLoader;
use Instride\Bundle\PimcoreFixturesBundle\Purger\FixturePurger;
use Instride\Bundle\PimcoreFixturesBundle\Test\Attributes\FixtureGroups;
use ReflectionMethod;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class PimcoreTestCase extends KernelTestCase
{
    protected ObjectFixturesLoader $fixturesLoader;
    private array $fixtureGroups = [];

    public function __construct()
    {
        parent::__construct();
        $container = static::getContainer();
        $this->fixturesLoader = $container->get('pimcore.fixtures.loader');
    }

    protected function setUp(): void
    {
        $this->setFixtureGroupsForMethod();
        $executor = new ObjectFixturesExecutor();
        $fixtures = $this->fixtureGroups
            ? $this->fixturesLoader->getFixturesByGroup($this->fixtureGroups)
            : $this->fixturesLoader->getSortedFixtures();
        $executor->executeFixtures($fixtures);
        self::bootKernel();
    }

    protected function tearDown(): void
    {
        try {
            FixturePurger::purgeFixtures();
        } catch (\Exception $e) {
            throw new \Exception('Could not purge fixtures: ' . $e->getMessage());
        }
        parent::tearDown();
    }

    protected function addFixtureGroup(?string $group): void
    {
        $this->fixtureGroups[] = $group;
    }

    private function setFixtureGroupsForMethod(): void
    {
        $testMethod = $this->getName();
        $reflectionMethod = new ReflectionMethod($this, $testMethod);

        $attributes = $reflectionMethod->getAttributes(FixtureGroups::class);
        if ($attributes) {
            foreach ($attributes as $attribute) {
                $this->fixtureGroups = array_merge($this->fixtureGroups, $attribute->newInstance()->groups);
            }
        }
    }
}
