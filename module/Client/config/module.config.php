<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'client' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/client[/:controller[/:action[/:id]]]',

                    'defaults' => array(
                        'controller' => 'Client\Controller\User',
                        'action'     => 'index',
                        '__NAMESPACE__' => 'Client\Controller'
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
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        )
    ),

    'controllers' => array(
        'invokables' => array(
            'Client\Controller\User' => 'Client\Controller\UserController',
            'Client\Controller\Admin' => 'Client\Controller\AdminController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'index/index'   => __DIR__ . '/../view/index/index.phtml',
            'error/404'     => __DIR__ . '/../view/error/404.phtml',
            'error/index'   => __DIR__ . '/../view/error/index.phtml',
            'client/user/index'   => __DIR__ . '/../view/user/index.phtml',
            'client/user/detail'   => __DIR__ . '/../view/user/detail.phtml',
            'client/admin/index'   => __DIR__ . '/../view/admin/index.phtml',
            'client/admin/detail'   => __DIR__ . '/../view/admin/detail.phtml',
            'client/admin/add'   => __DIR__ . '/../view/admin/add.phtml',
            'client/admin/edit'   => __DIR__ . '/../view/admin/edit.phtml',
            'client/admin/delete'   => __DIR__ . '/../view/admin/delete.phtml',
        ),
        'template_path_stack' => array(
            'client' => __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),

    'navigation' => array(
        'default' => array(
            array(
                'label' => 'User',
                'route' => 'client',
                'controller' => 'user',
                'action' => 'index'
            ),
            array(
                'label' => 'Admin',
                'route' => 'client',
                'controller' => 'admin',
                'action' => 'index'
            ),
        ),
    ),
);
