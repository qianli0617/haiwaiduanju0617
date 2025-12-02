<?php

return [
    'autoload' => false,
    'hooks' => [
        'upgrade' => [
            'dramas',
        ],
        'app_init' => [
            'dramas',
            'uploads',
        ],
        'epay_config_init' => [
            'epay',
        ],
        'addon_action_begin' => [
            'epay',
        ],
        'action_begin' => [
            'epay',
        ],
        'config_init' => [
            'nkeditor',
        ],
        'module_init' => [
            'uploads',
        ],
        'upload_config_init' => [
            'uploads',
        ],
        'upload_delete' => [
            'uploads',
        ],
    ],
    'route' => [],
    'priority' => [],
    'domain' => '',
];
