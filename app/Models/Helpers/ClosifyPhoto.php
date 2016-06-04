<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-09-25
 * Time: 22:36
 */

namespace Antoree\Models\Helpers;

class ClosifyPhoto extends StoredPhoto
{
    const PREFIX = 'closify_photo_';

    public static function getPrefix()
    {
        return ClosifyPhoto::PREFIX;
    }
}