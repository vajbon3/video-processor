<?php

namespace Vanilla\utils;

use Vanilla\core\App;
use Vanilla\enums\MediaEnum;

class VideoProcessor
{
    const SCALE = 0.4;

    public static function generateThumbnail(File $file): string
    {
        $name = File::generateRandomName() . '.png';
        $path = App::$project_root . "/public/storage/thumbnails/$name";
        shell_exec("ffmpeg -i $file->temp_path -vf 'thumbnail' -frames:v 1 $path");
        return $name;
    }

    public static function compress(File $file): string
    {
        // calculate reduced bitrate
        $new_bitrate = self::getReducedBitrate($file);

        // build new file path
        $new_name = File::generateRandomName() . '.mp4';
        $new_path = App::$project_root . "/public/storage/videos/" . $new_name;

        // run ffmpeg
        shell_exec("ffmpeg -i $file->temp_path -b $new_bitrate $new_path -y");

        return $new_name;
    }

    public static function getReducedBitrate(File $file): int
    {
        return floor(($file->size->inBit() / self::getVideoLength($file)) * self::SCALE);
    }

    public static function getVideoLength(File $file): int
    {
        return shell_exec("ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $file->temp_path");
    }
}