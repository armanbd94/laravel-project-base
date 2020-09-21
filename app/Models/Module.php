<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['menu_id', 'type', 'module_name', 'divider_title', 'icon_class', 'url', 'order', 'parent_id', 'target'];
    

    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    public function parent(){
        return $this->belongsTo(Module::class,'parent_id','id');
    }

    public function children(){
        return $this->hasMany(Module::class,'parent_id','id')
                    ->orderBy('order','desc');
    }


}
