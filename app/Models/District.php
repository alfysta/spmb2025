<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['code', 'name', 'regency_id'];

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
