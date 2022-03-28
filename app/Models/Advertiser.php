<?php

namespace App\Models;

use App\Models\User;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advertiser extends Model
{
    use HasFactory;

    public function user() {
        return $this->hasOne(User::class);
    }

    public function offers() {
        return $this->hasMany(Offer::class);
    }
}
