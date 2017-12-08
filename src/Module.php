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
    public function bootstrap()
    {
        // Let's read all files from module config folder and set to Configuration
        $configDirPath = realpath(dirname(__DIR__)) . '/config/';
        $this->setModuleConfiguration($configDirPath);

        $application = $this->getApplication();
        $appConfig = $application->getConfiguration();

        // Add routes to dispatcher
        $application->getDispatcher()
                    ->addRoutes($appConfig->getPathValue('routes'));

        // Register resources, repositories and model fields
        $this->getApplication()
             ->getRepositoryManager()
             ->registerRepositories($appConfig->getPathValue('repositories'));
    }
}
