<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Slugger
{
    public static function slug(
        string $value,
        string $modelClass,
        string $column = 'slug'
    ): string {
        $baseSlug = Str::slug($value);
        $slug = $baseSlug;
        $counter = 1;

        while ($modelClass::where($column, $slug)->exists()) {
            $counter++;
            $slug = "{$baseSlug}-{$counter}";
        }

        return $slug;
    }
}
