<?php

declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Демо библиотеки Var-Dumper');

dump([
    '32' => '21',
    '31' => [
        '321' => [
            '321' => 'ddsads'
        ],
    ],
]);
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
