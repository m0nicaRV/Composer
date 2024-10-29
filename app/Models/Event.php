<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_name', 'event_detail',
    ];
    public function users(){
        return $this->belongsToMany('App\Models\User')->withTimestamps();
}

}
