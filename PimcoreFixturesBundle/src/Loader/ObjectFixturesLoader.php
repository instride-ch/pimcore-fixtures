<?php

declare(strict_types=1);

/**
 * instride AG.
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that is distributed with this source code.
 *
 * @copyright 2024 instride AG (https://instride.ch)
 */

namespace Instride\PimcoreFixturesBundle\Loader;

use Instride\PimcoreFixturesBundle\Fixture;
use Instride\PimcoreFixturesBundle\FixtureGroupInterface;

class ObjectFixturesLoader
{
    private array $fixtures = [];

    /**
     * Adds a fixture to the loader.
     *
     * @param Fixture $fixture The fixture to add.
     */
    public function addFixture(Fixture $fixture): void
    {
        $fixtureClass = get_class($fixture);

        if (isset($this->fixtures[$fixtureClass])) {
            return;
        }

        $this->fixtures[$fixtureClass] = $fixture;
    }

    /**
     * Adds multiple fixtures to the loader.
     *
     * @param array $fixtures The fixtures to add.
     */
    public function addFixtures(array $fixtures): void
    {
        foreach ($fixtures as $fixture) {
            $this->addFixture($fixture['fixture']);
        }
    }

    /**
     * Retrieves all fixtures from the loader.
     *
     * @return array The fixtures.
     */
    public function getSortedFixtures(): array
    {
        $sorted = [];
        $visited = [];

        foreach ($this->fixtures as $class => $fixture) {
            $this->sort($class, $fixture, $sorted, $visited);
        }

        return $sorted;
    }

    public function getFixturesByGroup(array $groups): array
    {
        $groupedFixtures = array_filter($this->fixtures, function ($fixture) use ($groups) {
            return $fixture instanceof FixtureGroupInterface && \in_array($fixture->getGroup(), $groups);
        });

        if(empty($groupedFixtures)) {
            throw new \InvalidArgumentException('No fixtures found for the requested group.');
        }

        $sorted = [];
        $visited = [];

        foreach ($groupedFixtures as $class => $fixture) {
            $this->sort($class, $fixture, $sorted, $visited, $groups);
        }
        return $sorted;
    }

    private function sort(string $class, Fixture|FixtureGroupInterface $fixture, array &$sorted, array &$visited, array $groups = null): void
    {
        if (!isset($visited[$class])) {
            $visited[$class] = true;
            foreach ($fixture->getDependencies() as $dependency) {
                if ($groups) {
                    if (!isset($this->fixtures[$dependency]) ||
                        !($this->fixtures[$dependency] instanceof FixtureGroupInterface) ||
                        !\in_array($this->fixtures[$dependency]->getGroup(), $groups)) {
                        throw new \InvalidArgumentException(sprintf('Fixture "%s" is not part of the requested group.', $dependency));
                    }
                }
                if (isset($this->fixtures[$dependency])) {
                    $this->sort($dependency, $this->fixtures[$dependency], $sorted, $visited, $groups);
                }
            }
            $sorted[] = $fixture;
        }
    }
}
