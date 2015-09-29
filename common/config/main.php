<?php
return [
    'name' => 'Mailwitch Email Services',
    'version' => '2.0.7',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
