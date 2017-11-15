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
     * Here goes the application version.
     */
    'version' => 'v0.1.0-dev',

    /*
     * Here goes the application default command. By default
     * the list of commands will appear. All commands
     * application commands will be auto-detected.
     *
     * 'default-command' => App\Commands\HelloCommand::class,
    */

    /*
     * If true, development commands won't be available as the app
     * will be in the production environment.
     */
    'production' => false,

    /*
     * If true, scheduler commands will be available.
     */
    'with-scheduler' => false,

    /*
     * Structure to build into app
     */
    'structure' => [
        'app/',
        'bootstrap/',
        'vendor/',
        'config/',
        'database/',
        'LICENSE',
        'README.md',
        'composer.json'
    ],

    /*
     * Here goes the application list of Laravel Service Providers.
     * Enjoy all the power of Laravel on your console.
     */
    'providers' => [
        App\Providers\AppServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class
    ],
];
