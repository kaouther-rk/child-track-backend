<?php

namespace App\Models;

use App\Models\Api\Main\Braclet;
use App\Models\Api\Main\Location;
use Illuminate\Database\Eloquent\Model;

class Danger extends Model
{
    public $fillable = ['name' , 'braclet_id'];
    public function braclet(){
        return $this->belongsTo(Braclet::class);
    }
    public function location(){
        return $this->morphOne(Location::class, 'locationable');
    }
}
