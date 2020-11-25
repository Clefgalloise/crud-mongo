<?php

return [

    'host' => env('MONGO_HOST', '127.0.0.1'),

    'port' => (int)env('MONGO_PORT', 27017),

    'database' => env('MONGO_DATABASE'),

    'username' => env('MONGO_USERNAME'),

    'password' => env('MONGO_PASSWORD')

];
