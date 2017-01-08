<?php
return [
// @chris68
    'name' => 'Mailwitch Email Services',
    'version' => '2.1.4',

    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
