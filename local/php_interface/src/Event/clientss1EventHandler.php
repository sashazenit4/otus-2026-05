<?php

namespace Otus\Event;

class clientss1EventHandler implements EventHandlerInterface
{
    public function onBeforeAdd(array $fields): array
    {
        $fields['NAME'] = 'Клиент: ' . $fields['NAME'];
        $allIblockHandler = new AllIblockEventHandler();
        $allIblockHandler->onBeforeAdd($fields);
        return $fields;
    }

    public function onBeforeUpdate(array $fields): array
    {
        return $fields;
    }
}
