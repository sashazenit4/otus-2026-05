<?php

use Bitrix\Main\Application;
use Bitrix\Main\Data\Cache;
use Bitrix\Main\Engine\CurrentUser;
use Otus\Orm\AuthorTable;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Тегированное кэширование d7');

$cache = Cache::createInstance();
$taggedCache = Application::getInstance()->getTaggedCache();

$cacheTime = 300;
$cacheId = 'authors_tag_cache_' . CurrentUser::get()->getId();
$cacheDir = 'authors';
$cacheTag = 'BOOK_LIST';

if ($cache->initCache($cacheTime, $cacheId, $cacheDir)) {
    echo 'Читаем из кэша:<br>';
    $authorList = $cache->getVars();
} else {
    echo 'Пишем в кэш:<br>';
    $cache->startDataCache();
    $taggedCache->startTagCache($cacheDir);

    $taggedCache->registerTag($cacheTag);

    $authorList = AuthorTable::getList()->fetchAll();

    $taggedCache->endTagCache();
    $cache->endDataCache($authorList);
}

dump($authorList);

//$taggedCache->clearByTag($cacheTag); /* = Application::getInstance()->getTaggedCache();*/

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
