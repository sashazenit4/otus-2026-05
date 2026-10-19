<?php

use Bitrix\Main\DI\ServiceLocator;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Демо работы Битриксового сервиса');

try {
    $serviceLocator = ServiceLocator::getInstance();
    $dealFactory = $serviceLocator->get('crm.service.container')->getFactory(\CCrmOwnerType::Deal);
    $deal = $dealFactory->getItem(6);
    var_dump($deal->getData());
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
