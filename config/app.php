<?php

/*
 * Here goes the application configuration.
 */
return [
    /*
     * Here goes the application name.
     */
    'name' => 'Open Resource Manager CLI',

    /*
    |--------------------------------------------------------------------------
    | Application Version
    |--------------------------------------------------------------------------
    |
    | This value determines the "version" your application is currently running
    | in. You may want to follow the "Semantic Versioning" - Given a version
    | number MAJOR.MINOR.PATCH when an update happens: https://semver.org.
    |
    */
    'version' => app('git.version'),


    /*
     * If true, development commands won't be available as the app
     * will be in the production environment.
     */
    'production' => false,

    /*
     * Structure to build into app
     */
    'structure' => [
        'app/',
        'bootstrap/',
        'vendor/',
        'docs/',
        'config/',
        'database/',
        'LICENSE',
        'builder-stub',
        '.env',
        'README.md',
        'composer.json'
    ],

    /*
     * Here goes the application list of Laravel Service Providers.
     * Enjoy all the power of Laravel on your console.
     */
    'providers' => [
        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,

    ],

    'aliases' => [
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
    ]
];
