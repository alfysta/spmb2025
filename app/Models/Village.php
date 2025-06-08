<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = ['code', 'name', 'postal_code', 'district_id'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
