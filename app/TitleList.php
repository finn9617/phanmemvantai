<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TitleList extends Model
{
    protected $table = 'tbl_menu';
    protected $fillable = [
        'menu_id', 'menu_parent_id', 'title', 'url', 'url2', 'url3', 'roles',
    ];

    public static function ListTitle($url)
    {
        $title = static::where('url', '=', $url)->select('title')->first()->toArray();

        return mb_strtoupper($title['title'], 'UTF-8');
    }
}
