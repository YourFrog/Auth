<?php

return array(
    'auth' => [
        'redirect' => [
            // Nazwa routera na który zostanie przekierowana osoba z niedozwolonym dostępem
            'disallow' => 'home',

            // Nazwa routera na który zostanie przekierowania osoba która się zalogowała
            'after-login' => null,

            // Nazwa routera na który zostanie przekierowana osoba po PEŁNYM wylogowaniu
            'after-logout' => 'home',

            // Strona po rejestracyjna
            'after-register' => 'user/after-register'
        ]
    ],
    'service_manager' => [
        'factories' => [
            // Fabryki zwiazane z konfiguracja
            'auth.configuration' => 'Auth\Configuration\Factory\ConfigFactory',

            // Fabryki procesów biznesowych
            'auth.business.account' => 'Auth\Business\Factory\AccountFactory',

            'auth.entitymanager' => 'Auth\EntityManager\Factory\EntityManager',
            'auth.toolbar' => 'Auth\DeveloperTools\Factory\PermissionCollector',
            'auth.service.authentication' => 'Auth\Service\Factory\Authentication',
            'auth.service.permission' => 'Auth\Service\Factory\Permission',
            'auth.form.annotation.builder' => 'Auth\Form\Factory\AnnotationBuilder',
            'auth.session.container' => 'Auth\Service\Factory\SessionContainer'
        ],
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
    'router' => array(
        'routes' => array(
            'user' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/user',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => [
                    'login' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/login',
                            'defaults' => [
                                'controller' => 'Auth\Controller\Website\Login',
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'logout' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/logout',
                            'defaults' => [
                                'controller' => 'Auth\Controller\Website\Login',
                                'action'     => 'logout',
                            ],
                        ],
                    ],
                    'register' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/register',
                            'defaults' => [
                                'controller' => 'Auth\Controller\Website\Login',
                                'action'     => 'register',
                            ],
                        ],
                    ],
                    'password-reminder' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/password-reminder',
                            'defaults' => [
                                'controller' => 'Auth\Controller\Website\Login',
                                'action'     => 'passwordReminder',
                            ],
                        ],
                    ]
                ],
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Auth\Controller\Website\Login' => 'Auth\Controller\Website\LoginController'
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
    ),
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOPgSql\Driver',
                'params' => [
                    'host'     => null,
                    'port'     => null,
                    'user'     => null,
                    'password' => null,
                    'dbname'   => null
                ]
            ]
        ],
        'driver' => [
            'orm_default' => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'Auth\Entity' => 'my_annotation_driver'
                ]
            ],

            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'my_annotation_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src'
                ],
            ]
        ]
    ]
);
