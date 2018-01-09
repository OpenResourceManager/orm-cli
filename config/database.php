<?php

/*
 * Here goes the illuminate/database component configuration. Once
 * installed, the configuration below is used to configure your
 * database component.
 */

return [
    /*
     * If true, migrations commands will be available.
     */
    'with-migrations' => true,

    'with-seeds' => false,

    /*
     * Here goes the application database connection configuration. By
     * default, we use `sqlite` as a driver. Feel free to use another
     * driver, be sure to check the database component documentation.
     */
    'connections' => [
        'default' => [
            'driver' => 'sqlite',
            'database' => ORM_DB_PATH,
        ],
    ],
];
