<?php

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\UserTable;
use Otus\Entity\Main\UserRepository;
use Otus\Crm\Service\Container;

$serviceLocator = ServiceLocator::getInstance();

$serviceLocator->addInstanceLazy('user.repository', [
    'constructor' => static function () {
        return new UserRepository(UserTable::class);
    }
]);

$serviceLocator->addInstanceLazy('crm.service.container', [
    'className' => Container::class,
]);
