<?php

namespace Vanilla\models;

use Vanilla\enums\MediaEnum;

class Media implements Model
{
    public ?int $id;
    public string $filepath;
    public string $name;
    public ?int $duration;
    public MediaEnum $media_type;
    public ?string $thumbnail;

    /**
     * @param int|null $id
     * @param string $filepath
     * @param string $name
     * @param int|null $duration
     * @param MediaEnum $media_type
     * @param string|null $thumbnail
     */
    public function __construct(?int $id, string $filepath, string $name, ?int $duration, MediaEnum $media_type,?string $thumbnail)
    {
        $this->filepath = $filepath;
        $this->name = $name;
        $this->duration = $duration;
        $this->media_type = $media_type;
        $this->thumbnail = $thumbnail;
    }

    public function save(): bool {
        return MediaDao::save($this);
    }

    public function delete(): bool
    {
        return MediaDao::delete($this);
    }
}