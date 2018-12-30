<?php

// @chris68
$oauth = parse_ini_file('/etc/apache2/oauth.key/mailwitch.com.ini', true);

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
// @chris68
    'id' => 'mwes2',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',

// @chris68
    'language' => 'de',
    'modules' => [
        'markdown' => [
            // the module class
            'class' => 'kartik\markdown\Module',
            // whether to use PHP SmartyPants to process Markdown output
            'smartyPants' => false,
        ],
    ],

    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
// @chris68
            'as loginLogger' => [
                'class' => 'common\behaviors\ProtocolLogin',
                // ... property init values ...
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
// @chris68
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

// @chris68
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'itemFile' => '@common/data/items.php', 
            'assignmentFile' => '@common/data/assignments.php', 
            'ruleFile' => '@common/data/rules.php', 
            'defaultRoles' => ['admin','moderator','trusted','user','anonymous'],
        ],
        'authClientCollection' => [
            // See http://code.tutsplus.com/tutorials/programming-with-yii2-authclient-integration-with-twitter-google-and-other-networks--cms-23489
            // and https://github.com/yiisoft/yii2-authclient/blob/master/docs/guide/quick-start.md
             'class' => 'yii\authclient\Collection',
             'clients' => [
                    'google' => [
                        'class' => 'yii\authclient\clients\Google',
                        'clientId' => $oauth['google']['clientId'],
                        'clientSecret' => $oauth['google']['clientSecret'],
                    ],
                 // etc.
             ],
         ],
        'i18n' => [
            'translations' => [
                'common' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                ],
                'base' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'yyyy-MM-dd',
//            'datetimeFormat' => 'yyyy-MM-dd H:i:s',
            //'timeFormat' => 'H:i:s',
        ],
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true,
        ],
    ],
    'params' => $params,
];
