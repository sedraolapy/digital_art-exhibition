<?php

return [

    'api' => [
        'per_minute' => env('RATE_LIMIT_API', 60),
    ],

    'sensitive' => [
        'local_per_minute' => env('RATE_LIMIT_SENSITIVE_LOCAL', 1000),
        'production_per_minute' => env('RATE_LIMIT_SENSITIVE', 10),
    ],

];