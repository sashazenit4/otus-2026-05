<?php

use Otus\Entity\Main\UserController;
// use Otus\Entity\Main\User;
use Otus\Entity\Main\UserRepository;
use Bitrix\Main\UserTable;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Демо работы DI');

try {
    $email = 'holinshura@gmail.com';
    $userRepository = new UserRepository(UserTable::class);
    $userController = new UserController($userRepository);
    echo $userController->handle($email);
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
