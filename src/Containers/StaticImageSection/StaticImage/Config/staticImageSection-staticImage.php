<?php

return [

    /**
     * Параметры кеша
     * should_config_cache - Стоит ли кешировать содержимое файла conversion-config.json.
     * Рекомендуется кешировать для повышения производительности
     *
     * config_name - Название, с которым содержимое файла conversion-config.json будет записано в кеш.
     */
    'cache' => [
        'should_config_cache' => true,
        'config_name' => env('STATIC_IMAGE_CACHE_CONFIG_NAME', 'laravel-static-image-config')
    ],

    /**
     * Стоит ли каждый раз создавать экземпляр класса для работы хелпера laravel_static_image().
     * Не рекомендуется
     */
    'always_generate' => false,

    /**
     * Значения по умолчанию
     */
    'default' => [

        /**
         * Форматы, в которые следует конвертировать изображения. Допустимые значения: webp, avif
         */
        'formats' => ['webp'],

        /**
         * В какие разрешения обрезать изображения
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
        'prefix' => 'conversions_',
    ]
];