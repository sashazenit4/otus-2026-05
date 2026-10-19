<?php

namespace Otus\Controller;

class BadController
{
    public function handleRequest($rule)
    {
        if ($rule === '1') {
            return $this->getFromDB();
        } elseif ($rule === '2') {
            return $this->getFrom1C();
        } else {
            return $this->getFromBitrixSP();
        }
    }
    private function getFromDB() {}

    private function getFrom1C() {}

    private function getFromBitrixSP() {}
}
