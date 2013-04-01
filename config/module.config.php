<?php
return array(
    'navigation' => array(
        'admin' => array(
            'contacts' => array(
                'label' => 'Contacts',
                'route' => 'zfcadmin/contact',
            ),
            'companies' => array(
                'label' => 'Companies',
                'route' => 'zfcadmin/contact/company',
            ),
        ),
    ),
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
            'zfcadmin' => array(
                'child_routes' => array(
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
                            'contact' => array(
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
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'add-phone' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/add-phone',
                                            'defaults' => array(
                                                'controller' => 'speckcontact',
                                                'action' => 'add-phone',
                                            ),
                                        ),
                                    ),
                                    'add-company' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/add-company',
                                            'defaults' => array(
                                                'controller' => 'speckcontact',
                                                'action' => 'add-company',
                                            ),
                                        ),
                                    ),
                                    'add-email' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/add-email',
                                            'defaults' => array(
                                                'controller' => 'speckcontact',
                                                'action' => 'add-email',
                                            ),
                                        ),
                                    ),
                                    'add-address' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/add-address',
                                            'defaults' => array(
                                                'controller' => 'speckcontact',
                                                'action' => 'add-address',
                                            ),
                                        ),
                                    ),
                                    'add-url' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/add-url',
                                            'defaults' => array(
                                                'controller' => 'speckcontact',
                                                'action' => 'add-url',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'add-contact' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/add',
                                    'defaults' => array(
                                        'controller' => 'speckcontact',
                                        'action' => 'add-contact',
                                    ),
                                ),
                            ),
                            'company' => array(
                                'type' => 'Literal',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/company',
                                    'defaults' => array(
                                        'controller' => 'speckcontact',
                                        'action' => 'list-companies',
                                    ),
                                ),
                                'child_routes' => array(
                                    'add-company' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/add',
                                            'defaults' => array(
                                                'controller' => 'speckcontact',
                                                'action' => 'add-company',
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]+',
                                            ),
                                            'defaults' => array(
                                                'controller' => 'speckcontact',
                                                'action' => 'view-company',
                                            ),
                                        ),
                                        'may_terminate' => true,
                                        'child_routes' => array(
                                            'add-contact' => array(
                                                'type' => 'Literal',
                                                'options' => array(
                                                    'route' => '/add-contact',
                                                    'defaults' => array(
                                                        'controller' => 'speckcontact',
                                                        'action' => 'add-contact',
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
