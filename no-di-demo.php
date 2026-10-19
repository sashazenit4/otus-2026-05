<?php

use Otus\Entity\Main\UserRepository;
use Otus\Entity\Main\UserController;
use Bitrix\Main\UserTable;

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

global $APPLICATION;

$APPLICATION->SetTitle('Пример установки зависимостей без DI');

$controller = new UserController(new UserRepository(UserTable::class));
echo $controller->handle('holinshura@gmail.com');

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
