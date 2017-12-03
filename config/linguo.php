<?php

return [

    'headers' => [
        'Project-Id-Version'    => 'linguo',
        'Language-Team'         => 'TeamName <info@example.com>'
    ],

    'sources' => [
        base_path('resources/views'),
        base_path('app/Http/Controllers'),
    ] ,

    'i18nPath'  => base_path('resources/lang'),
    'domain'    => 'default',
    'domains'   => [],
    'locales'   => ['es', 'en'],     // may be en or en_GB
];