<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'gcs' => [
            'driver' => 'gcs',
            'key_file_path' => env('GOOGLE_CLOUD_KEY_FILE', null), // optional: /path/to/service-account.json
            'key_file' => [
                "type" => "service_account",
                "project_id" => "high-producer-401206",
                "private_key_id" => "33d275c00bd679c0a18a0fbccd34925d16996b90",
                "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCy28EtrfXaRqCh\nLk1IuFZd4nWd7B4NGp7XCVqZFpNN5r8w34tIFdSo12ONYNXYvygpvEQsUcKbVaEB\neHBR2PQXWUKBBGtYvgbYFQi3GCEug6uHmU+mXDlXC1VR9Xnvzmy0spYgUHCk+JKv\n3ONzA/qYZlt4PdaYmvJoh/4PF/XzutG30tMT0777ylEdKF13Kbcke9/iOv6r4IH7\nCfSw6AN/vypfoe6BkStfNEonDDEZbPqtVNhGR04v3UqTqCd9jpKB3rkfEB93qY3w\n2vWkJfamGZPr5CAauXzaIZBZrtwG8tvBF+SAnf8O4fe7vSbFa2dnWtQQ9nUTUKzw\nUhM76DXVAgMBAAECggEAJkw53B8gwqFW6cxxTf3yuF2yU6Nod+PYWTEujhMwbYDY\nNY3YVBIgnBqqvW4bvDKKVg1zB45mPj6ioB765fuvoIRDYj7hAXqHGqO+Xv4ytLQK\n+ZkRXgznVkUd+tO2TWwFCNgonzi6Ngjn1/JTXaBfe1yHf4K2Pa0H9OwRsYeu6YYe\nedf2K7KvZvd8FD8pX3tP/6yW96ZGwttkVTvra70d3/8mNqRzqWktv3vRAHUDlnDc\nQACZYfZ3LFI+f5O/2v9/IAx+hSNkcWZt+LczO7NCWy9akxp0/QtUU7KiODwEP5Dr\n+Yw7OmxMp4o4wU9YS/PIiKA4PFnU+HwBYSTrE8yw7QKBgQDhNwJ9GnHYSkHhr7ly\nc1xcv4YZZmZXztLGfOGVzYSNbcSXnADL1qEy8OtynixAKmCDiy3NyoPWOPIwtF33\ndko32E8FEb49c3olNSwVzU4kcDjsxmlyXM6vJvSc7y2HEpnYhxnpSs6DKGmNEcge\ni9kVFlq3wVLwp32JUES5Wa9EywKBgQDLTpVpX1NJcpj/shzZ2t8KLnCqL1Wjd8kZ\njx5qmzXl4LRtHXHFk+GqTays6imyFE91T8fAkmx8ILRuUi2J5YehiyhdwKELr73z\nbgn6uxY/Jdj1eOcOlVJE+GOgMfd7KY8ATJPiwMYbFtDaGVO8uyqVqToIopGiMAHh\nJWH5mpG73wKBgQDFAiryJtzpuGOTOfW+UX29QGjc9T+Xlju5F+r58RL/6MKtYPEt\nXq4acrdzxzusUaWlzG0f9QSIs73grxb37wkTeuv84j2JYee6fp324GZ355dUQGhj\nex3uB+S5F1y7KKFd0Sjwc9jc0NAscB6f4fPex3RKBBo6nDlrkcTcYsC4KwKBgH4B\nz7MGhQ1xvIhGMYGJGVIrJGMmgVKWzIpN3RE/77Dxi4JRjJFjrasrB0oIvB0GX5Ub\nBHhDiH+KmaoCvvzHyT+Di1pIKMigfP+ihQbk683pvEWwUK0GOX5L4RuJvJSWVm5e\nCA6zYlWp13pF1lOUQbmOsExnzhGS5adQzx+wAIFLAoGAHqMsf5uBJYniFSMV98K2\n3e2YQNwMra4CqgP23utr1C0LPCwYgDxJwgmdN+KrxTjja+9lGoBCdXyKu54a+1pa\n4544u/HGp0wXgAIme/gu39DW9sLS0Fs99iYp8RhZ7oAXUJ6t7pSc4zMpW2wkYZiT\nOnjulHOVVTzqZpXACtSWQ8A=\n-----END PRIVATE KEY-----\n",
                "client_email" => "mms-974@high-producer-401206.iam.gserviceaccount.com",
                "client_id" => "112432120645089890898",
                "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
                "token_uri" => "https://oauth2.googleapis.com/token",
                "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
                "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/mms-974%40high-producer-401206.iam.gserviceaccount.com",
                "universe_domain" => "googleapis.com"
            ], // optional: Array of data that substitutes the .json file (see below)
            'project_id' => env('GOOGLE_CLOUD_PROJECT_ID', 'your-project-id'), // optional: is included in key file
            'bucket' => env('GOOGLE_CLOUD_STORAGE_BUCKET', 'ems.tpm-facility.com'),
            'path_prefix' => env('GOOGLE_CLOUD_STORAGE_PATH_PREFIX', ''), // optional: /default/path/to/apply/in/bucket
            'storage_api_uri' => env('GOOGLE_CLOUD_STORAGE_API_URI', null), // see: Public URLs below
            'api_endpoint' => env('GOOGLE_CLOUD_STORAGE_API_ENDPOINT', null), // set storageClient apiEndpoint
            'visibility' => 'public', // optional: public|private
            'visibility_handler' => null, // optional: set to \League\Flysystem\GoogleCloudStorage\UniformBucketLevelAccessVisibility::class to enable uniform bucket level access
            'metadata' => ['cacheControl' => 'public,max-age=86400'], // optional: default metadata
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
