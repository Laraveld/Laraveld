<?php

declare(strict_types=1);

return [
    'filesystems' => [
        'laraveld_stubs' => [
            'driver' => 'local',
            'root' => __DIR__.'/../stubs/',
        ],
        'project_config' => [
            'driver' => 'local',
            'root' => config_path(),
        ],
    ],
];
