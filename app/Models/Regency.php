<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $fillable = ['code', 'name', 'province_id'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
