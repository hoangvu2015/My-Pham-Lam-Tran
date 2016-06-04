<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-16
 * Time: 09:50
 */

namespace Antoree\Models\Themes;


use Antoree\Models\Helpers\CallableObject;

class ContentFilter
{
    private static $filters = [];

    private static function check($id)
    {
        if (!isset(self::$filters[$id])) {
            self::$filters[$id] = [];
        }
    }

    /**
     * @param string $id
     * @param CallableObject $callableObject
     */
    public static function add($id, CallableObject $callableObject)
    {
        if (empty($id)) return;

        self::check($id);

        self::$filters[$id][] = $callableObject;
    }

    /**
     * @param string $id
     * @param string $content
     * @return mixed
     */
    public static function flush($id, $content)
    {
        self::check($id);

        $filter = self::$filters[$id];
        foreach ($filter as $callableObject) {
            $callableObject->unShiftParam($content);
            $content = $callableObject->execute();
        }

        return $content;
    }
}