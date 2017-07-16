<?php

namespace Mailman;

return array(
    'doctrine' => array(
        'driver' => array(
            'mailman_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Mailman/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Mailman\Entity' => 'mailman_entities'
                )
            )
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Mailman\Entity\User',
                'identity_property' => 'username',
                'credential_property' => 'password'
            ),
        ),
        'configuration' => array(
            'orm_default' => array(
                'numeric_functions' => array(),
                'datetime_functions' => array(
                    'Unix_Timestamp' => 'Mailman\DQL\UnixTimestamp'
                ),
                'string_functions' => array(
                    'Field' => 'Mailman\DQL\Field'
                ),
                'metadata_cache' => 'filesystem',
                'query_cache' => 'filesystem',
                'result_cache' => 'filesystem',
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Mailman\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'auth' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/auth[/:action]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'    => 'Mailman\Controller\Auth',
                        'action'        => 'login',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard',
                    ),
                ),
            ),
            'contact' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/contact[/:action]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'    => 'Mailman\Controller\Contact',
                        'action'        => 'list',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard',
                    ),
                ),
            ),
            'register' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/register[/:action]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'    => 'Mailman\Controller\Register',
                        'action'        => 'list',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard',
                    ),
                ),
            ),
            'email' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/email[/:action]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'    => 'Mailman\Controller\Email',
                        'action'        => 'list',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard',
                    ),
                ),
            ),
            'variable' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/variable[/:action]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'    => 'Mailman\Controller\Variable',
                        'action'        => 'list',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard',
                    ),
                ),
            ),
            'task' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/task[/:action]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'    => 'Mailman\Controller\Task',
                        'action'        => 'list',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Mailman\Controller\Index'    => 'Mailman\Controller\IndexController',
            'Mailman\Controller\Auth'     => 'Mailman\Controller\AuthController',
            'Mailman\Controller\Contact'  => 'Mailman\Controller\ContactController',
            'Mailman\Controller\Register' => 'Mailman\Controller\RegisterController',
            'Mailman\Controller\Email'    => 'Mailman\Controller\EmailController',
            'Mailman\Controller\Variable' => 'Mailman\Controller\VariableController',
            'Mailman\Controller\Task'     => 'Mailman\Controller\TaskController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'mailman/index/index'       => __DIR__ . '/../view/mailman/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404-debug.phtml',
            'error/index'             => __DIR__ . '/../view/error/index-debug.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'tasks' => array(
                    'options' => array(
                        'route'    => 'process_tasks',
                        'defaults' => array(
                            'controller' => 'Mailman\Controller\Task',
                            'action' => 'process'
                        )
                    )
                )
            )
        )
    )
);
