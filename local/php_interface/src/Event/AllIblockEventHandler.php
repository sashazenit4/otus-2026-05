<?php

namespace Otus\Event;

class AllIblockEventHandler implements EventHandlerInterface
{
    public function onBeforeAdd(array $fields): array
    {
        $fields['NAME'] = $fields['NAME'] . '___OTUS';
        return $fields;
    }

    public function onBeforeUpdate(array $fields): array
    {
        return $fields;
    }
}
