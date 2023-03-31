<?php
namespace Vanilla\models;

interface Dao
{
    public static function get($primary);
    public static function all();
    public static function save($item);
    public static function update($item,array $params);
    public static function delete($item);
}