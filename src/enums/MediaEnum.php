<?php

namespace Vanilla\enums;

enum MediaEnum: int
{
    case photo = 0;
    case video = 1;

    // Fulfills the interface contract.
    public function label(): string
    {
        return match($this) {
            self::photo => 'photo',
            self::video => 'video',
        };
    }
}
