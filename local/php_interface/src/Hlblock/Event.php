<?php

namespace Otus\Hlblock;

use Bitrix\Main\Entity\EntityError;
use Bitrix\Main\Entity\Event as OrmEvent;
use Bitrix\Main\Entity\EventResult;

class Event
{
    public static function onBeforeElementAdd(OrmEvent $event): EventResult
    {
        $result = new EventResult();

        $fields = $event->getParameter('fields');
        $xmlId = trim((string)($fields['UF_XML_ID'] ?? ''));

        if ($xmlId === '') {
            return $result;
        }

        $dataClass = $event->getEntity()->getDataClass();

        $existedElement = $dataClass::getList([
            'select' => ['ID'],
            'filter' => [
                '=UF_XML_ID' => $xmlId,
            ],
            'limit' => 1,
        ])->fetch();

        if ($existedElement !== false) {
            $result->setErrors([
                new EntityError(
                    'Элемент с таким UF_XML_ID уже существует.'
                ),
            ]);
        }

        // установка идентификатора нового элемента как последний id + 2
        $lastElement = $dataClass::getList([
            'select' => ['ID'],
            'order' => ['ID' => 'DESC'],
            'limit' => 1,
        ])->fetch();

        if ($lastElement !== false) {
            $newId = (int)$lastElement['ID'] + 2;
            $result->modifyFields(['ID' => $newId]);
        }

        return $result;
    }
}
