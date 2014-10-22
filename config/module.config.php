<?php
return [
    'rumeaulib_aclbackend' => [
        'role_entity_class' => 'Application\Entity\Role',
    ],

    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'rumeaulibaclbackend-acl' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/acl[/[:controller[/[:action]]]]',
                            'defaults' => [
                                '__NAMESPACE__' => 'RumeauLibAclBackend\Controller',
                                'controller' => 'acl',
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'invokables' => [
            'RumeauLibAclBackend\Controller\Acl' => 'RumeauLibAclBackend\Controller\AclController',
            'RumeauLibAclBackend\Controller\Roles' => 'RumeauLibAclBackend\Controller\RolesController',
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],

    'service_manager' => [
        'factories' => [
            'RumeauLibAclBackend\Mapper\Role' => 'RumeauLibAclBackend\Service\RoleMapperFactory',
            'RumeauLibAclBackend\Options\Module' => 'RumeauLibAclBackend\Service\ModuleOptionsFactory',
        ],
    ],
];