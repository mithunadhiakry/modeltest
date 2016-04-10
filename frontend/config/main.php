<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'timeZone' => 'Asia/Dhaka',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'homeUrl' => '/model_test',
    'components' => [
        'request' => [
            'baseUrl' => '/model_test',
            'enableCsrfValidation' => false,
        ],
        'user' => [
            'identityClass' => 'frontend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_frontendUser', // unique for frontend
            ]
        ],
        'session' => [
            'name' => 'PHPFRONTSESSID',
            'savePath' => sys_get_temp_dir(),
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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'modeltest.abedon@gmail.com',
                'password' => '%model0TesT%',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        /*'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@app/web/themes/in-the-mountains'],
                'baseUrl' => '@web/themes/in-the-mountains',
            ],
        ],*/
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules' => array(
                // '<alias:examcenter>/<alias2:examcenter | about | contact>' => 'exam/examcenter',
                'discounts' => 'page/discounts',
                'about-us' => 'page/about-us',
                'points-rewards' => 'page/points-rewards',
                'membership' => 'page/membership',
                'how-to-pay' => 'page/how-to-pay',
                'faq' => 'page/faq',
                'contact-us' => 'page/contact-us',
                'terms-of-use' => 'page/terms-of-use',
                'privacy-policy' => 'page/privacy-policy',
                'instruction' => 'page/instruction',
                'batches' => 'page/batches',
                'students' => 'page/students',
                'how-to-assign' => 'page/how-to-assign',
                'how-to-create-exam' => 'page/how-to-create-exam',
                'article/index' => 'blog/index',
                'article/view/<id:(\w|\ |\-)+>' => 'blog/view',
                'page/<page_slug:(\w|\ |\-)+>' => 'page/viewcommonpage',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<exam_id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
        'urlManagerBackEnd' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '/model_test/backend/web',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        
    ],
    'params' => $params,
    'vendorPath' => dirname(__DIR__).'/../vendor',
];
