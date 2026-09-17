<?php

namespace Otus\Event;

interface EventHandlerInterface
{
    public function onBeforeAdd(array $fields): array;
    public function onBeforeUpdate(array $fields): array;
}
