<?php

use Bitrix\Crm\Service\Container;
use Otus\Crm\Service\Container as OtusContainer;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Работа с подмененной фабрикой смарт-процессов');

try {
    $entityTypeId = OtusContainer::getEntityTypeIdByCode('domainProlongation');
    $domainFactory = Container::getInstance()->getFactory($entityTypeId);
    $item = $domainFactory->createItem();
    $domainFactory->getAddOperation($item)->launch();
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
