<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{

    protected $fillable = [
        'user_id', 'departure', 'departure_lat', 'departure_long', 'arrival', 'arrival_lat', 'arrival_long', 'date', 'places', 'information'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contactRequests()
    {
        return $this->hasMany(Contact::class);
    }
}
