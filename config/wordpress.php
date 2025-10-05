<?php

/**
 * Laravel WordPress Connector
 * 
 * @package mrdulal
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 */

return [
    /*
    |--------------------------------------------------------------------------
    | WordPress Database Connection
    |--------------------------------------------------------------------------
    |
    | Configuration for connecting to the WordPress database.
    | Set 'enabled' to false to disable the WordPress integration.
    |
    */

    'enabled' => env('WP_CONNECTOR_ENABLED', true),

    'host' => env('WP_DB_HOST', '127.0.0.1'),
    'port' => env('WP_DB_PORT', '3306'),
    'database' => env('WP_DB_DATABASE', 'wordpress'),
    'username' => env('WP_DB_USERNAME', 'root'),
    'password' => env('WP_DB_PASSWORD', ''),
    'prefix' => env('WP_DB_PREFIX', 'wp_'),

    /*
    |--------------------------------------------------------------------------
    | WordPress Table Names
    |--------------------------------------------------------------------------
    |
    | Customize the table names if your WordPress installation uses
    | different table names or prefixes.
    |
    */

    'tables' => [
        'users' => 'users',
        'posts' => 'posts',
        'comments' => 'comments',
        'terms' => 'terms',
        'term_taxonomy' => 'term_taxonomy',
        'term_relationships' => 'term_relationships',
        'options' => 'options',
        'postmeta' => 'postmeta',
        'commentmeta' => 'commentmeta',
        'usermeta' => 'usermeta',
    ],

    /*
    |--------------------------------------------------------------------------
    | Filament Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Filament admin panel integration.
    |
    */

    'filament' => [
        'navigation_group' => 'WordPress',
        'navigation_sort' => 1,
        'enable_widgets' => true,
    ],
];
