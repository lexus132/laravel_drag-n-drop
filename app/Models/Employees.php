<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    
    public function heads(){
    	return $this->hasMany('App\Models\Employees', 'head');
    }
    
    public function header(){
    	return $this->belongsTo('App\Models\Employees', 'head', 'id');
    }
    
    public function avatar(){
    	return $this->hasOne('App\Models\Avatar', 'employe_id', 'id');
    }
}
