<?php

use Bitrix\Main\EventManager;

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
