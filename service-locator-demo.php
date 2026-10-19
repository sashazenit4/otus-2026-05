<?php

use Bitrix\Main\DI\ServiceLocator;

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

global $APPLICATION;

$APPLICATION->SetTitle('Пример использования ServiceLocator');

$serviceLocator = ServiceLocator::getInstance();
$userRepository = $serviceLocator->get('user.repository');

echo $userRepository->findByEmail('holinshura@gmail.com');

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
