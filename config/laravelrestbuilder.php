<?php

return [
    'build_active'  =>  true,
    'company_id_code' => 'user()->com_id',
    'user_id_code'  =>  'user()->id',
    'copy_to'   =>  '',    
    'project_id'    =>  0,
    'file'  =>  [],
    'theme' => 'Architect',
    'menu'  => [
        'Menu'   => [
            'User' =>  [
                [
                    'name'  => 'User',
                    'url'   => "/user"
                ],
                [
                    'name'  => 'Create',
                    'url'   => "/createUser"
                ],
            ],
            'Project' =>  [
                [
                    'name'  => 'List',
                    'url'   => "/project"
                ],
                [
                    'name'  => 'Create',
                    'url'   => "/createProject"
                ],
            ],
            'Moduls'    => [
                [
                    'name'  => 'List',
                    'url'   => "/list"
                ],
                [
                    'name'  => 'Create',
                    'url'   => "/create"
                ],
            ],
            'Emails'    => [
                [
                    'name'  => 'List',
                    'url'   => "/emails"
                ],
                [
                    'name'  => 'Create',
                    'url'   => "/createEmail"
                ],
            ],
            'Events'    => [
                [
                    'name'  => 'List',
                    'url'   => "/events"
                ],
                [
                    'name'  => 'Create',
                    'url'   => "/createEvent"
                ],
            ],
            'Tables'    => [
                [
                    'name'  => 'List',
                    'url'   => "/listTable"
                ],
                [
                    'name'  => 'Create',
                    'url'   => "/createTable"
                ],
            ],
            'Lang'    => [
                [
                    'name'  => 'List',
                    'url'   => "/lang/list"
                ],
                [
                    'name'  => 'Create',
                    'url'   => "/lang/create"
                ],
            ],
            'Dokumentasi'   => [
                [
                    'name'  => 'Dokumentasi',
                    'url'   => "/dokumentasi"
                ]
            ]
        ]
    ]
];