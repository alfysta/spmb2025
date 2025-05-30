<?php

namespace App\Models\Siswa;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';
    protected $guarded = [];
    protected $appends = ['image_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->foto ? Storage::temporaryUrl($this->foto, now()->addMinute()) : ''
        );
    }
}
