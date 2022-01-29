<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VesselOpex extends Model
{
    use HasFactory;

    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }
}
