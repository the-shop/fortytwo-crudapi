<?php

namespace Framework\CrudApi;

use Framework\Base\Module\BaseModule;

/**
 * Class Module
 * @package Framework\CrudApi
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public function loadConfig()
    {
        // Let's read all files from module config folder and set to Configuration
        $configDirPath = realpath(dirname(__DIR__)) . '/config/';
        $this->setModuleConfiguration($configDirPath);
    }
}
