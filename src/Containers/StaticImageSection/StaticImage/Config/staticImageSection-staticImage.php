<?php

return [

    /**
     *
     */
    'cache' => [
        'should_config_cache' => true,
        'config_name' => env('STATIC_IMAGE_CACHE_CONFIG_NAME', 'laravel-static-image-config')
    ],

    /**
     *
     */
    'always_generate' => false,

    /**
     *
     */
    'default' => [

        /**
         *
         */
        'formats' => ['webp'],

        /**
         *
         */
        'screens' => [
            'xs' => 320,
            'sm' => 640,
            'md' => 768,
            'lg' => 1024,
            'xl' => 1280,
            'xxl' => 1536,
        ],

        /**
         *
         */
        'prefix' => '_ebs_',
    ]
];