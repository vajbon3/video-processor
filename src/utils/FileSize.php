<?php

namespace Vanilla\utils;

class FileSize
{
    private int $size;

    public function __construct(int $size)
    {
        $this->size = $size;
    }

    public function inMB(): int
    {
        return floor($this->size / pow(1024,2));
    }

    public function inBit(): int
    {
        return $this->size * 8;
    }
}