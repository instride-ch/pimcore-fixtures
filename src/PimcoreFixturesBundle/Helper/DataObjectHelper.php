<?php

namespace Instride\PimcoreFixturesBundle;
use Pimcore\Model\DataObject\Folder;
use Pimcore\Model\DataObject\Service;

class DataObjectHelper
{

    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function createObjectFolder(): Folder
    {
        return Service::createFolderByPath($this->path);
    }
}
