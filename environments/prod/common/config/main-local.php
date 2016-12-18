<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
// @chris68
            'dsn' => 'pgsql:host=localhost;dbname=mwes2',
            'username' => 'mailwitch',
            'password' => 'mailwitch',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
