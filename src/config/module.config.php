<?php

return array(
    'auth' => [
        'redirect' => [
            // Nazwa routera na który zostanie przekierowana osoba z niedozwolonym dostępem
            'disallow' => 'user/disallow',

            // Nazwa routera na który zostanie przekierowania osoba która się zalogowała
            'after-login' => null,

            // Nazwa routera na który zostanie przekierowana osoba po PEŁNYM wylogowaniu
            'after-logout' => 'home',

            // Strona po rejestracyjna
            'after-register' => 'user/after-register',

            // Strona po przypomnieniu hasła
            'after-password-reminder' => 'user/after-password-reminder'
        ],
        'doctrine' => [
            'orm' => 'doctrine.entitymanager.orm_default'
        ]
    ],
    'service_manager' => [
        'factories' => [
            // Fabryki zwiazane z konfiguracja
            'auth.configuration' => 'Auth\Configuration\Factory\ConfigFactory',

            // Fabryki procesów biznesowych
            'auth.business' => 'Auth\Business\Factory\Business',
            'auth.business.account' => 'Auth\Business\Factory\AccountFactory',

            'auth.entitymanager' => 'Auth\EntityManager\Factory\EntityManager',
            'auth.repository' => 'Auth\EntityManager\Factory\Repository',

            'auth.toolbar' => 'Auth\DeveloperTools\Factory\PermissionCollector',
            'auth.service.authentication' => 'Auth\Service\Factory\Authentication',
            'auth.service.permission' => 'Auth\Service\Factory\Permission',
            'auth.form.annotation.builder' => 'Auth\Form\Factory\AnnotationBuilder',
            'auth.session.container' => 'Auth\Service\Factory\SessionContainer'
        ]
    ],
    'validators' => [
        'abstract_factories' => [
            'LoginIsExists' => 'Auth\Form\Validate\Factory\AbstractFactory',
        ],
        'factories' => [
            'StringCompare' => 'Auth\Form\Validate\Factory\StringCompareFactory'
        ]
    ],
    'view_helpers' => [
        'factories' => [
            'permission' => 'Auth\Helper\Factory\Permission'
        ]
    ],
    'controller_plugins' => [
        'factories' => [
            'permission' => 'Auth\Plugin\Factory\Permission',
        ]
    ],
    'zenddevelopertools' => [
        'profiler' => [
            'collectors' => [
                'auth.toolbar' => 'auth.toolbar'
            ]
        ],
        'toolbar' => [
            'entries' => [
                'auth.toolbar' => 'auth/toolbar/permisison'
            ]
        ]
    ],
    'controllers' => array(
        'invokables' => array(
            'Auth\Controller\Website\Auth' => 'Auth\Controller\Website\AuthController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'login/index'           => __DIR__ . '/../view/auth/login/index.twig',
            'login/register'        => __DIR__ . '/../view/auth/login/register.twig',

            'auth/toolbar/permisison' => 'C:\xampp\htdocs\Learn\module\Auth\view\auth\toolbar\permission.twig'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    )
);
