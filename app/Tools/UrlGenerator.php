<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20.08.2018
 * Time: 20:53
 */

namespace App\Tools;


use App\RedisImitation;

class UrlGenerator
{
    public static function generate(): string
    {
        $possiblePath = RedisImitation::find('autogenerated_path');

        $successSave = false;
        while (!$successSave) {
            $possiblePath['value'] = $possiblePath['value'] + 1;
            try {
                $possiblePath->save();
                $successSave = true;
            } catch (\Exception $e) {
                $successSave = false;
            }
        }

        return $possiblePath['value'];
    }
}