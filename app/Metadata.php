<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Metadata extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_metadata';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'meta_id', 'meta_group', 'meta_name', 'value1', 'value2', 'value3', 'description',
    ];


    public static function loadMetadata(){
        $metadata = static::all()->toArray();
        if(!session()->has('metadata')){
            return session()->push('metadata',$metadata);
        }
        return '';
    }

    public static function getGroupList($group_name) {
        $group = session()->get('metadata');
        $group_list = array();
        if(!empty($group)){
            for($i=0; $i< count($group[0]); $i++){
                if($group[0][$i]['meta_group'] == $group_name){
                    array_push($group_list,$group[0][$i]);
                }
            }

            return $group_list;
        }

        return 'có lỗi xảy ra';
        
    }

    public static function getMedatata($group_name, $metadata_name){
        if(!empty(Metadata::getGroupList($group_name))){
            $Getmetadata = Metadata::getGroupList($group_name);
        }
        else {
            return 0;
        }
        $meta = array();
        for($i=0; $i< count($Getmetadata); $i++){
            if($Getmetadata[$i]['meta_name'] == $metadata_name){
                array_push($meta,$Getmetadata[$i]);
            }
        }
        return $meta;
    }
}
