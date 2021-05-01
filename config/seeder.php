<?php

return [
    'roles' => [
        [
            'name' => 'admin',
            'guard_name' => 'api',
            'permissions' => [

            ],
        ],
        [
            'name' => 'user',
            'guard_name' => 'api',
            'permissions' => [

            ],
        ],
        [
            'name' => 'vendor',
            'guard_name' => 'api',
            'permissions' => [

            ],
        ],

    ],

    'permissions' => [
        [
            'name' => 'add users'
        ],
        [
            'name' => 'edit users'
        ],
        [
            'name' => 'delete users'
        ]
    ],

    'users' => [
        [
            'name' => 'Admin',
            'email' => 'admin@vendormachine.test',
            'password' => 'password',
            'role' => 'admin',
        ],
        [
            'name' => 'user',
            'email' => 'user@vendormachine.test',
            'password' => 'password',
            'role' => 'user',
        ],

    ],
];
