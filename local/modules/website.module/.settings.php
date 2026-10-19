<?php

return [
    'services' => [
        'value' => [
            'user.repository' => [
                // 'className' => \Otus\Entities\Main\UserRepository::class, // если в класс не нужно передавать аргументы
                'constructor' => fn() =>
                new \Otus\Entity\Main\UserRepository(\Bitrix\Main\UserTable::class),
                // 'constructorParams' => [\Bitrix\Main\UserTable::class],
            ],
        ],
    ],
];
