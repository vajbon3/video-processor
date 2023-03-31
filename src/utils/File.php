<?php

namespace Vanilla\utils;

use Vanilla\enums\MediaEnum;

class File
{
    public string $name;
    public string $extension;
    public string $temp_path;
    public FileSize $size;
    public MediaEnum $type;
    public ?string $error;

    public function __construct(array $file)
    {
        $this->name = $file['name'];
        $this->temp_path = $file['tmp_name'];
        $this->size = new FileSize($file['size']);

        // resolve type
        $type = explode('/', $file['type']);
        $this->extension = $type[1];

        if ($type[0] === 'image') {
            $this->type = MediaEnum::photo;

            // codec check
            if (!in_array($type[1], ['png', 'jpg', 'jpeg'])) {
                $this->error = 'only png,jpg,jpeg files allowed';
            }

        } elseif ($type[0] === 'video') {
            $this->type = MediaEnum::video;

            // codec check
            if ($type[1] !== 'mp4') {
                $this->error = 'only mp4 allowed';
            }
        } else {
            // type check
            $this->error = 'only photos/videos allowed';
            return;
        }

        // size check
        if ($this->type === MediaEnum::photo && $this->size->inMB() > 10) {
            $this->error = 'photo size should be under 10 MB';
        }

        if ($this->type === MediaEnum::video && $this->size->inMB() > 50) {
            $this->error = 'video size should be under 50 MB';
        }
    }

    public static function generateRandomName(): string {
        return substr("abcdefghijklmnopqrstuvwxyz", mt_rand(0, 25), 1).substr(md5(time()), 1);
    }
}