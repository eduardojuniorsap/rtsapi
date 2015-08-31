<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Engineer extends Model
{
    protected $fillable = array('iuser', 'name', 'email', 'available');



	public function areas() {
	
		return $this->belongsToMany(Area::class, 'engineer_areas', 'engineer_id', 'area_id');

	}
	
	public function schedule() {
	
		return $this->hasMany(Schedule::class)->orderBy('date');

	}
}
