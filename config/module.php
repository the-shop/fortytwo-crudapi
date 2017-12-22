<?php

use Framework\Base\Application\BaseApplication;
use Framework\CrudApi\Controller\Resource;
use Framework\RestApi\Listener\ConfirmRegistration;
use Framework\RestApi\Listener\RegistrationListener;
use Framework\RestApi\Listener\RequestLogger;

return [
    'routes' => [
        [
            'get',
            '/{resourceName}',
            '\Framework\CrudApi\Controller\Resource::loadAll',
        ],
        [
            'get',
            '/{resourceName}/{identifier}',
            '\Framework\CrudApi\Controller\Resource::load',
        ],
        [
            'post',
            '/{resourceName}',
            '\Framework\CrudApi\Controller\Resource::create',
        ],
        [
            'put',
            '/{resourceName}/{identifier}',
            '\Framework\CrudApi\Controller\Resource::update',
        ],
        [
            'patch',
            '/{resourceName}/{identifier}',
            '\Framework\CrudApi\Controller\Resource::partialUpdate',
        ],
        [
            'delete',
            '/{resourceName}/{identifier}',
            '\Framework\CrudApi\Controller\Resource::delete',
        ],
    ],
    'listeners' => [
        BaseApplication::EVENT_APPLICATION_HANDLE_REQUEST_PRE => [
            RequestLogger::class,
        ],
        Resource::EVENT_CRUD_API_RESOURCE_CREATE_PRE => [
            RegistrationListener::class,
        ],
        Resource::EVENT_CRUD_API_RESOURCE_CREATE_POST => [
            ConfirmRegistration::class,
        ],
    ],
];
