<?php

namespace Framework\CrudApi;

use Framework\Base\Module\BaseModule;
use Framework\CrudApi\Repository\GenericRepository;
use Framework\RestApi\RestApiConfigurationInterface;

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

    /**
     * @inheritdoc
     */
    public function bootstrap()
    {
        if (
            empty(
                $models = $this->getApplication()
                               ->getConfiguration()
                               ->getPathValue('models')
            ) === false
        ) {
            // Format models configuration
            $modelsConfiguration = $this->generateModelsConfiguration($models);

            // Register resources and model fields
            $this->getApplication()
                 ->getRepositoryManager()
                 ->registerResources($modelsConfiguration['resources'])
                 ->registerModelFields($modelsConfiguration['modelFields']);
        }
    }

    /**
     * @param $modelsConfig
     *
     * @return array
     */
    private function generateModelsConfiguration(array $modelsConfig)
    {
        $generatedConfiguration = [
            'resources' => [],
            'modelFields' => [],
        ];
        foreach ($modelsConfig as $modelName => $options) {
            $generatedConfiguration['resources'][$options['collection']] = GenericRepository::class;
            $generatedConfiguration['modelFields'][$options['collection']] = $options['fields'];
        }

        return $generatedConfiguration;
    }
}
