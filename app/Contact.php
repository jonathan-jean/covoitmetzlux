<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'to', 'from', 'answered'
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to');
    }

    public function travel()
    {
        return $this->belongsTo(Travel::class);
    }

    public function scopeUnanswered($query)
    {
        return $query->where('answered', false);
    }
}
