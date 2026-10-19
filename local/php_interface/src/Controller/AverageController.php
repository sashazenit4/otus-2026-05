<?php

namespace Otus\Controller;

class AverageController
{
    private DatabaseSource $dbSource;
    private BitrixSmartProcessSource $bitrixSpSource;
    private External1CSource $_1cSource;

    public function handleRequest($rule)
    {
        if ($rule === '1') {
            return $this->dbSource->read();
        } elseif ($rule === '2') {
            return $this->_1cSource->read();
        } else {
            return $this->bitrixSpSource->read();
        }
    }
}
