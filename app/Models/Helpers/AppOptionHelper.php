<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-09-24
 * Time: 07:22
 */

namespace Antoree\Models\Helpers;


use Antoree\Models\AppOption;

class AppOptionHelper
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    private static $app_options;

    private static function check()
    {
        if (!isset(self::$app_options)) {
            self::$app_options = AppOption::all();
        }
    }

    public static function reload()
    {
        self::$app_options = AppOption::all();
    }

    public static function all()
    {
        self::check();

        return self::$app_options;
    }

    public static function fullKey($key, $locale = '', $assoc_order = '')
    {
        if (!empty($locale)) {
            $key = $locale . '.' . $key;
        }
        if (!empty($assoc_order)) {
            $key .= '.' . $assoc_order;
        }
        return $key;
    }

    public static function get($key, $default = '', $locale = '', $assoc = false)
    {
        self::check();

        if ($assoc && !is_array($default)) {
            $default = [];
        }

        if (!empty($key)) {
            if (!empty($locale)) {
                $key = $locale . '.' . $key;
            }

            if ($assoc) {
                $appOptions = self::$app_options->filter(function ($item) use ($key) {
                    return preg_match('/^' . str_replace('.', '\.', $key) . '\.[a-zA-Z0-9]+$/', $item->key);
                })->all();

                $values = [];
                foreach ($appOptions as $appOption) {
                    $keyParts = explode('.', $appOption->key);
                    $values[array_pop($keyParts)] = $appOption->value;
                }
                if (!empty($values)) {
                    return $values;
                }
            } else {
                $appOption = self::$app_options->where('key', $key)->first();
                if ($appOption) {
                    return $appOption->value;
                }
            }
        }

        return $default;
    }

    public static function set($key, $value, $locale = '', $assoc = false)
    {
        self::check();

        if (empty($key)) return false;

        if (!empty($locale)) {
            $key = $locale . '.' . $key;
        }

        if (is_array($value) && $assoc) {
            self::un_set($key);

            $values = $value;
            for ($i = 0, $loop = count($values); $i < $loop; ++$i) {
                $appOption = new AppOption();
                $appOption->key = $key . '.' . $i;
                $appOption->value = $values[$i];
                $appOption->save();
            }
        } else {
            $appOption = self::$app_options->where('key', $key)->first();
            if ($appOption) {
                $appOption->value = $value;
                $appOption->save();
            } else {
                $appOption = new AppOption();
                $appOption->key = $key;
                $appOption->value = $value;
                $appOption->save();
            }
        }

        return true;
    }

    public static function un_set($key, $locale = '', $reload = false)
    {
        if (empty($key)) return false;

        if (!empty($locale)) {
            $key = $locale . '.' . $key;
        }

        AppOption::where('key', $key)->orWhere('key', 'like', $key . '.%')->delete();

        if ($reload) {
            self::reload();
        }

        return true;
    }
}