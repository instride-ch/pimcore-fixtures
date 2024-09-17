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

namespace Instride\Bundle\PimcoreFixturesBundle\Loader;

class FixtureConfigLoader
{
    private array $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function addConfig(array $config): array
    {
        return $this->config = \array_merge_recursive($this->config, $config);
    }

    public function getConfig(string $className): array
    {
        return $this->config['pimcore_fixtures']['classes'][$className];
    }
}
