<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public function offer() {
        return $this->belongsTo(Offer::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
