<?php

namespace Otus\Controller;

class BestController
{
    public function __construct(private DBSourceInterface $dbSource) {}

    public function handleRequest()
    {
        return $this->dbSource->read();
    }
}
