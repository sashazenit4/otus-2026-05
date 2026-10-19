<?php

use Otus\DI\AutoWiringContainer;
use Otus\Entity\Main\UserController;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Демо работы DI контейнера с автосвязыванием');

try {
    $email = 'holinshura@gmail.com';
    $userController = ((new AutoWiringContainer())->get(UserController::class));
    echo $userController->handle($email);
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
