<?php

namespace Instride\Bundle\PimcoreFixturesBundle\Helper;

use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\DataObject\Service;

class DataObjectHelper
{
    private static string $defaultPath = '/TestObjects';

    public static function setParent(Concrete $obj, AbstractObject|string $parent = null): void
    {
        if (!$parent) {
            $parent = self::$defaultPath;
        }

        $obj->setParent($parent instanceof AbstractObject ? $parent : Service::createFolderByPath($parent));
    }
}
