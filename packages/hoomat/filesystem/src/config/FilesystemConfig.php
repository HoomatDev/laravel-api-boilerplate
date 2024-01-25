<?php

return [
    // base prefix
    'prefix' => 'api/files',

    // base middleware
    'middleware' => ['api', 'auth:sanctum'],

    'default_disk' => 'public',

    'public_disk' => 'public',

    'private_disk' => 'private',
];
