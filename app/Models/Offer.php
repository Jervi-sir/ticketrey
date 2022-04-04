<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    public function advertiser() {
        return $this->belongsTo(Advertiser::class);
    }

    public function template() {
        return $this->belongsTo(Template::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
}
