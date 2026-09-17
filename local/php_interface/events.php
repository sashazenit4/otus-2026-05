<?php

use Bitrix\Main\EventManager;
use Otus\Event\EventHandlerFactory;

$eventManager = EventManager::getInstance();

/**
 * Названия события для ORM-классов, в том числе, для Highload-блоков:
 * OnBeforeAdd
 * OnAfterAdd
 * OnBeforeUpdate
 * OnAfterUpdate
 * OnBeforeDelete
 */

// Правило именования событий: <имя_hl_block><имя_события>
$eventManager->addEventHandler('', 'PantoneColorsOnBeforeAdd', [
    '\Otus\Hlblock\Event',
    'onBeforeElementAdd'
]);

$eventManager->addEventHandler('iblock', 'OnBeforeIblockElementAdd', function (array &$fields) {
    $handler = EventHandlerFactory::create($fields['IBLOCK_ID']);
    $fields = $handler?->onBeforeAdd($fields);
    return $fields;
});
