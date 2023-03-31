<?php

namespace Vanilla\models;

use Vanilla\core\App;
use Vanilla\enums\MediaEnum;

class MediaDao implements Dao
{

    public static function get($primary): Media
    {
        $stmt = App::$db->query("SELECT * FROM media where id = ?", [$primary]);

        $media = $stmt->fetch();

        return new Media($media['id'], $media['filepath'], $media['name'], $media['duration'], MediaEnum::from($media['media_type']), $media['thumbnail']);
    }

    public static function all(): array
    {
        $stmt = App::$db->query("SELECT * FROM media", []);
        $medias = [];
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $medias[] = new Media($row['id'], $row['filepath'], $row['name'], $row['duration'], MediaEnum::from($row['media_type']), $row['thumbnail']);
        }

        return $medias;
    }

    public static function allPhotos(): array {
        $stmt = App::$db->query("SELECT * FROM media where media_type = 0", []);
        $medias = [];
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $medias[] = new Media($row['id'], $row['filepath'], $row['name'], $row['duration'], MediaEnum::from($row['media_type']), $row['thumbnail']);
        }

        return $medias;
    }

    public static function allVideos(): array {
        $stmt = App::$db->query("SELECT * FROM media where media_type = 1", []);
        $medias = [];
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $medias[] = new Media($row['id'], $row['filepath'], $row['name'], $row['duration'], MediaEnum::from($row['media_type']), $row['thumbnail']);
        }

        return $medias;
    }

    public static function save($item): bool
    {
        try {
            App::$db->query("INSERT INTO media(filepath,name,duration,media_type,thumbnail) VALUES(?,?,?,?,?)",
                [
                    $item->filepath,$item->name,$item->duration,$item->media_type->value,$item->thumbnail,
                ]);
        } catch(\Exception $e) {
            die($e->getMessage());
            return false;
        }

        return true;
    }

    public static function update($item, array $params)
    {
        // TODO: Implement update() method.
    }

    public static function delete($item): void
    {
        // TODO: Implement update() method.
    }
}