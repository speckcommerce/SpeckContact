<?php
return array(
    'service_manager' => array(
        'aliases' => array(
            'speckcontact_db_adapter' => 'Zend\Db\Adapter\Adapter'
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'speckcontact' => 'SpeckContact\Controller\ContactController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'SpeckContact' => __DIR__ . '/../view',
        ),
    ),

    'router' => array(
        'routes' => array(
            'contact' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/contact',
                    'defaults' => array(
                        'controller'    => 'speckcontact',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'view' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/:id',
                            'constraints' => array(
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'speckcontact',
                                'action' => 'view',
                            ),
                        ),
                    ),
                    'company' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/company/:id',
                            'contstraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'speckcontact',
                                'action' => 'company',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
