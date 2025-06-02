<?php

namespace App\Models\Siswa;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $table = 'berkas';
    protected $guarded = [];

    public function getPreviewUrlAttribute()
    {
        $urls = collect([
            'image' => [
                'mimes' => [
                    'image/gif',
                    'image/avif',
                    'image/apng',
                    'image/png',
                    'image/svg+xml',
                    'image/webp',
                    'image/jpeg'
                ],
                'preview_url' => url("storage/images/{$this->nisn}/{$this->file_name}")
            ],
            'document' => [
                'mimes' => [
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/pdf'
                ],
                'preview_url' => asset('images/file-type-document.svg'),
            ],
        ]);

        $fileType = $urls->first(function ($item) {
            return in_array($this->mime_type, $item['mimes']);
        });

        return $fileType['preview_url'] ?? asset("images/file-type-other.svg");
    }
}
