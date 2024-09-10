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

namespace Instride\PimcoreFixturesBundle\Executor;

use Instride\PimcoreFixturesBundle\Fixture;
use Instride\PimcoreFixturesBundle\Purger\FixturePurger;

class ObjectFixturesExecutor
{

    /**
     * Executes all fixtures.
     *
     * @param array $fixtures The fixtures to execute.
     */
    public function executeFixtures(array $fixtures): void
    {
        foreach ($fixtures as $fixture) {
            if ($fixture instanceof Fixture) {
                $this->createFixture($fixture);
            }
        }
    }

    private function createFixture(Fixture $fixture): void
    {
        $result = $fixture->load();
        if (\is_array($result)) {
            foreach ($result as $object) {
                FixturePurger::addObject($object);
            }
        } else {
            FixturePurger::addObject($result);
        }
    }
}
