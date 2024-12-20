<?php

/**
 * This file is part of Laravel Entrust,
 * Handle Role-based Permissions for Laravel.
 *
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Migration Suffix
    |--------------------------------------------------------------------------
    |
    | This is the array that contains the information of the user models.
    | This information is used in the add-trait command, and for the roles and
    | permissions relationships with the possible user models.
    |
    | The key in the array is the name of the relationship inside the roles and permissions.
    |
    */
    'migrationSuffix' => 'laravel_entrust_setup_tables',

    /*
    |--------------------------------------------------------------------------
    | Laravel Entrust User Models
    |--------------------------------------------------------------------------
    |
    | These are the user models used by the application to handle ACL for
    | different guards. You can specify multiple user models here.
    |
    */
    'user_models' => [
        'users' => App\Models\User::class,
        'employees' => App\Models\Employee::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel Entrust User Tables
    |--------------------------------------------------------------------------
    |
    | These are the tables used by the application to save users to the database.
    | Define both `users` and `employees` tables here to handle permissions for
    | different guards.
    |
    */
    'user_tables' => [
        'users' => 'users',
        'employees' => 'employees',
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel Entrust Models
    |--------------------------------------------------------------------------
    |
    | These are the models used by Laravel Entrust to define the roles and permissions.
    |
    */
    'models' => [
        'role'          => 'App\Models\Role',
        'permission'    => 'App\Models\Permission',
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel Entrust Default Configurations
    |--------------------------------------------------------------------------
    |
    | These Configurations are used by Laravel Entrust to define the defaults
    | Specify multiple guards to support `web` and `employee` guards.
    |
    */
    'defaults' => [
        'guard' => 'web', // Default guard
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel Entrust Tables
    |--------------------------------------------------------------------------
    |
    | These are the tables used by Laravel Entrust to store all the authorization data.
    |
    */
    'tables' => [
        'roles'             => 'roles',
        'permissions'       => 'permissions',
        'role_user'         => 'role_user',
        'permission_role'   => 'permission_role',
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel Entrust Foreign Keys
    |--------------------------------------------------------------------------
    |
    | Define foreign keys for both `users` and `employees` to support relationships.
    |
    */
    'foreign_keys' => [
        'user' => 'user_id',
        'employee' => 'employee_id',
        'role' => 'role_id',
        'permission' => 'permission_id',
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel Entrust Middleware
    |--------------------------------------------------------------------------
    |
    | This configuration helps to customize the Laravel Entrust middleware behavior.
    |
    */
    'middleware' => [
        /**
         * Define if the laratrust middleware are registered automatically in the service provider
         */
        'register' => true,

        /**
         * Method to be called in the middleware return case.
         * Available: abort|redirect
         */
        'handling' => 'abort',

        /**
         * Handlers for the unauthorized method in the middlewares.
         */
        'handlers' => [
            /**
             * Aborts the execution with a 403 code and provides the response text
             */
            'abort' => [
                'code' => 403,
                'message' => 'You don\'t have permission to access this page.'
            ],

            /**
             * Redirects the user to the given URL with an optional flash message.
             */
            'redirect' => [
                'url' => '/',
                'message' => [
                    'key' => 'error',
                    'content' => 'You don\'t have permission to access this page.'
                ]
            ],
        ],
    ],
];
