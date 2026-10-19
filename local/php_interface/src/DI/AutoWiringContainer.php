<?php

namespace Otus\DI;

use Closure;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use Bitrix\Main\UserTable;
use Otus\Entity\Main\UserRepository;

class AutoWiringContainer implements ContainerInterface
{
    /**
     * Ручные "рецепты": как собрать объект, если автоматически это сделать нельзя.
     * @var array<string, Closure>
     */
    private array $definitions = [];

    /**
     * Уже собранные объекты (каждый сервис создаётся один раз).
     * @var array<string, mixed>
     */
    private array $instances = [];

    /**
     * Что собираем прямо сейчас — нужно, чтобы поймать циклические зависимости.
     * @var array<string, true>
     */
    private array $resolving = [];

    public function __construct()
    {
        $this->definitions = [
            // Конструктор ждёт строку (имя таблицы) — по типу её не угадать,
            // поэтому этот сервис описываем вручную.
            UserRepository::class => fn() => new UserRepository(UserTable::class),

            // UserController больше не нужен: autowiring соберёт его сам,
            // увидев в конструкторе UserRepository.
        ];

        // Сам контейнер тоже можно внедрять
        $this->instances[ContainerInterface::class] = $this;
        $this->instances[self::class] = $this;
    }

    /**
     * Добавить или переопределить рецепт снаружи.
     * Фабрика получает контейнер аргументом: fn(Container $c) => new Foo($c->get(Bar::class))
     */
    public function set(string $id, Closure $factory): void
    {
        $this->definitions[$id] = $factory;
        unset($this->instances[$id]);
    }

    public function has(string $id): bool
    {
        if (array_key_exists($id, $this->instances) || isset($this->definitions[$id])) {
            return true;
        }

        // Интерфейсы и абстрактные классы сюда не пройдут: class_exists для интерфейса = false,
        // а абстрактный класс отсеет isInstantiable()
        return class_exists($id) && (new ReflectionClass($id))->isInstantiable();
    }

    public function get(string $id): mixed
    {
        if (array_key_exists($id, $this->instances)) {
            return $this->instances[$id];
        }

        if (isset($this->resolving[$id])) {
            $chain = implode(' -> ', array_keys($this->resolving)) . " -> {$id}";
            throw new ContainerException("Циклическая зависимость: {$chain}");
        }

        $this->resolving[$id] = true;

        try {
            $object = isset($this->definitions[$id])
                ? ($this->definitions[$id])($this)
                : $this->autowire($id);
        } finally {
            unset($this->resolving[$id]);
        }

        return $this->instances[$id] = $object;
    }

    /**
     * Собирает класс сам: смотрит на конструктор и достаёт из контейнера всё, что тот просит.
     */
    private function autowire(string $class): object
    {
        if (!class_exists($class)) {
            throw new NotFoundException(
                "Не найден сервис или класс: {$class}. Если это интерфейс — пропишите реализацию в definitions."
            );
        }

        $reflection = new ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            throw new ContainerException(
                "Класс {$class} нельзя создать напрямую (абстрактный или приватный конструктор). Пропишите его в definitions."
            );
        }

        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return new $class();
        }

        $args = [];
        foreach ($constructor->getParameters() as $param) {
            $args[] = $this->resolveParameter($param, $class);
        }

        return $reflection->newInstanceArgs($args);
    }

    /**
     * Решает, что передать в один параметр конструктора.
     */
    private function resolveParameter(ReflectionParameter $param, string $class): mixed
    {
        $type = $param->getType();

        // 1. Параметр с типом-классом (UserRepository $repo) — берём из контейнера
        if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
            $dependency = $type->getName();

            if ($this->has($dependency)) {
                return $this->get($dependency);
            }
        }

        // 2. Есть значение по умолчанию — берём его
        if ($param->isDefaultValueAvailable()) {
            return $param->getDefaultValue();
        }

        // 3. Тип допускает null — передаём null
        if ($type !== null && $type->allowsNull()) {
            return null;
        }

        // 4. Сдаёмся с понятным сообщением
        $typeName = $type ? (string) $type : 'без типа';
        throw new ContainerException(
            "Не могу подставить параметр \${$param->getName()} ({$typeName}) в конструктор {$class}. "
                . "Пропишите {$class} в definitions вручную."
        );
    }
}
