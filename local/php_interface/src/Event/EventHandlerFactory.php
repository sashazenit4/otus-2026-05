<?php

namespace Otus\Event;

use Otus\Iblock\Helper;

class EventHandlerFactory
{
    public static function create(?int $iblockId): ?EventHandlerInterface
    {
        $iblockCode = Helper::getIblockCodeById($iblockId);
        if (null === $iblockCode) {
            return new AllIblockEventHandler();
        }

        $iblockCode = str_replace('_', '', $iblockCode);
        $iblockCode = str_replace('.', '', $iblockCode);
        $iblockCode = str_replace(',', '', $iblockCode);
        $iblockCode = str_replace(';', '', $iblockCode);
        $iblockCode = str_replace('/', '', $iblockCode);

        $className = __NAMESPACE__ . '\\' . $iblockCode . 'EventHandler';
        if (class_exists($className)) {
            return new $className;
        }

        return new AllIblockEventHandler();
    }
}
