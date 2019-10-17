<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cseo_menu_setups extends Model
{
    protected $guarded = ['id'];

        public function parent()
        {
            return $this->belongsTo('App\cseo_menu_setups', 'parent_id');
        }

        public function children()
        {
            return $this->hasMany('App\cseo_menu_setups', 'parent_id');
        }
}
