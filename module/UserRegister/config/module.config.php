<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace UserRegister;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'UserRegister\Controller\Main',
                        'action'     => 'index',
                    ],
                ],
            ],
            'register' =>[
                'type' => 'Segment',
                'options' => [
                    'route'    => '/register[/][:action]',
                    'defaults' => [
                        'controller' => 'UserRegister\Controller\Register',
                        'action'     => 'index',
                    ],
                ],
            ],
            'search' =>[
                'type' => 'Literal',
                'options' => [
                    'route'    => '/search',
                    'defaults' => [
                        'controller' => 'UserRegister\Controller\Search',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'invokables' => [
            // Table
            'UserRegister\Resource\Db\Table\PrefectureTable' => Resource\Db\Table\PrefectureTable::class,
        ],
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'factories' => [
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
            'SessionManager' => 'Zend\Session\Service\SessionManagerFactory',
            'ViewHelperManager' => 'Zend\Mvc\Service\ViewHelperManagerFactory',
            // Service
            'UserRegister\Service\RegisterService' => Service\Factories\RegisterServiceFactory::class,
        ],
    ],
    'translator' => [
        'locale' => 'ja_JP',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
        ],
        'factories' => [
            'UserRegister\Controller\Main' => Controller\Factories\MainControllerFactory::class,
            'UserRegister\Controller\Register' => Controller\Factories\RegisterControllerFactory::class,
            'UserRegister\Controller\Search' => Controller\Factories\SearchControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.twig',
            'error/404'               => __DIR__ . '/../view/error/404.twig',
            'error/index'             => __DIR__ . '/../view/error/index.twig',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    // Placeholder for console routes
    'console' => [
        'router' => [
            'routes' => [
            ],
        ],
    ],
    // ZfcTwig
    'zfctwig' => [
        'extensions' => [
            TwigExtension\CommonExtension::class,
        ],
    ],
    // Session
    'session' => [
        'class' => '\Zend\Session\Config\SessionConfig',
        'options' => [
            'name' => 'user_register',
            'remember_me_seconds' => 14400,
            'use_cookies' => true,
            'cookie_httponly' => true,
            'cookie_lifetime' => 7200,
            'cookie_path' => '/',
            'cookie_secure' => true,
            'gc_maxlifetime' => 57600,
        ],
        'storage' => '\Zend\Session\Storage\SessionArrayStorage',
    ],
];
