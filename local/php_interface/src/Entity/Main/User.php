<?php

namespace Otus\Entity\Main;

class User
{
    public string $email;
    public string $name;

    // пример магических функций в php
    public function __toString()
    {
        return $this->email . ' ' . $this->name;
    }
}
