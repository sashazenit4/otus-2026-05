<?php

use Otus\DI\Container;
use Otus\Entity\Main\UserController;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Демо работы DI контейнера');

try {
    $email = 'holinshura@gmail.com';
    $userController = ((new Container())->get(UserController::class));
    echo $userController->handle($email);
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
