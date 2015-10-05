<?php

/**
 *  Konfiguracja routera
 */

return [
    'router' => [
        'routes' => [
            'user' => [
                'type' => 'Literal',
                'options' => [
                    'route'    => '/auth',
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'disallow' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/disallow',
                            'defaults' => [
                                'controller' => 'Auth\Controller\Website\Auth',
                                'action'     => 'disallow',
                            ],
                        ],
                    ],
                    'login' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/login',
                            'defaults' => [
                                'controller' => 'Auth\Controller\Website\Auth',
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'logout' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/logout',
                            'defaults' => [
                                'controller' => 'Auth\Controller\Website\Auth',
                                'action'     => 'logout',
                            ],
                        ],
                    ],
                    'register' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/register',
                            'defaults' => [
                                'controller' => 'Auth\Controller\Website\Auth',
                                'action'     => 'register',
                            ],
                        ],
                    ],
                    'password-reminder' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/password-reminder',
                            'defaults' => [
                                'controller' => 'Auth\Controller\Website\Auth',
                                'action'     => 'passwordReminder',
                            ],
                        ],
                    ],
                    'after-password-reminder' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/after-password-reminder',
                            'defaults' => [
                                'controller' => 'Auth\Controller\Website\Auth',
                                'action'     => 'afterPasswordReminder',
                            ],
                        ],
                    ]
                ],
            ]
        ]
    ]
];