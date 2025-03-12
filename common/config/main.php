<?php

use common\repositories\databases\AuthorDBRepository;
use common\repositories\databases\BookDBRepository;
use common\repositories\interfaces\AuthorRepositoryInterface;
use common\repositories\interfaces\BookRepositoryInterface;
use common\repositories\interfaces\SubscriptionRepositoryInterface;
use common\repositories\databases\SubscriptionDBRepository;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'container' => [
        'definitions' => [
            BookRepositoryInterface::class => BookDBRepository::class,
            AuthorRepositoryInterface::class => AuthorDBRepository::class,
            SubscriptionRepositoryInterface::class => SubscriptionDbRepository::class,
        ]
    ],
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];
