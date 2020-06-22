<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Psy\Util\Str;

class NumericList implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return \Illuminate\Support\Collection
     */
    public function get($model, $key, $value, $attributes)
    {
        $arr = \Illuminate\Support\Str::of($value)->split('/((?<!\\\|\r)\n)|((?<!\\\)\r\n)/');
        foreach ($arr as $key => $string) {
            if(empty($string)) {
                unset ($arr[$key]);
            }
        }

        return $arr;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  string  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
       return $value;
    }
}
