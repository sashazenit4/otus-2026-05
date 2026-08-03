<?php

use Otus\Orm\BookTable;
use Bitrix\Main\Application;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Кеш запросов d7');

// BookTable::cleanCache();

$connection = Application::getConnection();
$connection->startTracker();
$books = BookTable::getList([
    'cache' => [
        'ttl' => 180,
        'cache_joins' => true,
    ],
    'select' => [
        'AUTHORS',
        'TITLE',
    ],
])->fetchAll();
$connection->stopTracker();

$tracker = $connection->getTracker();

dump($tracker->getQueries());
dump($books);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
