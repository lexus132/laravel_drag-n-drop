<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    public function employ(){
    	return $this->belongsTo('App\Models\Employees', 'id', 'employe_id');
    }
}
