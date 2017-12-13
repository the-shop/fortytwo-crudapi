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
    public function bootstrap()
    {
        // Let's read all files from module config folder and set to Configuration
        $configDirPath = realpath(dirname(__DIR__)) . '/config/';
        $this->setModuleConfiguration($configDirPath);

        /**
         * @var CrudApiApplicationInterface $application
         */
        $application = $this->getApplication();
        /**
         * @var RestApiConfigurationInterface $appConfig
         */
        $appConfig = $application->getConfiguration();
        $repositoryManager = $application->getRepositoryManager();

        // Add routes to dispatcher
        $application->getDispatcher()
                    ->addRoutes($appConfig->getPathValue('routes'));

        // Add listeners to application
        if (
            empty($listeners = $appConfig->getPathValue('listeners')) === false
        ) {
            foreach ($listeners as $event => $arrayHandlers) {
                foreach ($arrayHandlers as $handlerClass) {
                    $application->listen($event, $handlerClass);
                }
            }
        }

        // Register model adapters
        if (
            empty($modelAdapters = $appConfig->getPathValue('modelAdapters')) === false
        ) {
            foreach ($modelAdapters as $model => $adapters) {
                foreach ($adapters as $adapter) {
                    $repositoryManager->addModelAdapter($model, new $adapter());
                }
            }
        }

        // Register model primary adapters
        if (
            empty($primaryModelAdapter = $appConfig->getPathValue('primaryModelAdapter')) === false
        ) {
            foreach ($primaryModelAdapter as $model => $primaryAdapter) {
                $repositoryManager->setPrimaryAdapter($model, new $primaryAdapter());
            }
        }

        //Register Services
        if (
            empty($services = $appConfig->getPathValue('services')) === false
        ) {
            foreach ($services as $serviceName => $config) {
                $application->registerService(new $serviceName($config));
            }
        }

        if (
            empty($models = $appConfig->getPathValue('models')) === false
        ) {
            // Format models configuration
            $modelsConfiguration = $this->generateModelsConfiguration($models);

            // Register resources and model fields
            $repositoryManager->registerResources($modelsConfiguration['resources'])
                              ->registerModelFields($modelsConfiguration['modelFields']);
        }

        // Register repositories
        if (
            empty($repositories = $appConfig->getPathValue('repositories')) === false
        ) {
            $repositoryManager->registerRepositories($repositories);
        }

        // Register Acl rules
        if (
            empty($acl = $appConfig->getPathValue('acl')) === false
        ) {
            $application->setAclRules($acl);
        }

        // Register authenticatable models
        if (
            empty($auth = $appConfig->getAuthenticatables()) === false
        ) {
            $application->getRepositoryManager()
                        ->addAuthenticatableModels($auth);
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
