<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name', 'component'];


    public function engineers() {
        return $this->belongsToMany(Engineer::class, 'engineer_areas', 'area_id', 'engineer_id');
    }

}
