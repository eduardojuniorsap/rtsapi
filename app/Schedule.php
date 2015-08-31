<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
		'engineer_id',
		'date',
		'start',
		'end',
		'on_session',	
	];
	
	public function engineer() {
		return $this->belongsTo(Engineer::class);
	}	
	
}
