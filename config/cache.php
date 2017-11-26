<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/25/17
 * Time: 3:45 PM
 */

return [
    'default' => 'file',
    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => ORM_CACHE_PATH,
        ],
    ],
];