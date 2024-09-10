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

namespace Instride\PimcoreFixturesBundle\Registry;

use Pimcore\Model\DataObject\Concrete;

class FixtureRegistry
{
    private static array $fixtures = [];

    /**
     * Adds a fixture to the registry with an identifier.
     *
     * @param string $identifier The identifier for the fixture.
     * @param mixed $fixture The fixture to add.
     */
    public static function addFixture(string $identifier, Concrete $fixture): void
    {
        if (\array_key_exists($identifier, self::$fixtures)) {
            return;
        }
        self::$fixtures[$identifier] = $fixture;
    }

    /**
     * Retrieves a fixture from the registry.
     *
     * @param string $identifier The identifier of the fixture.
     * @return Concrete|null The fixture if found, null otherwise.
     */
    public static function getFixture(string $identifier): ?Concrete
    {
        return self::$fixtures[$identifier] ?? null;
    }
}
