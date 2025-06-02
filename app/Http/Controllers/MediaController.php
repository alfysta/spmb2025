<?php

namespace App\Http\Controllers;

use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MediaController extends Controller
{

    public function index()
    {
        $media = MediaResource::collection(Media::with('author')->paginate());
        return Inertia::render('CreateMedia', [
            'media' => $media
        ]);
    }

    public function store()
    {
        request()->validate([
            'file' => ['file', 'max:5000']
        ], [
            'max' => 'File yang anda upload lebih dari 5 Mb'
        ]);

        $file = request()->file('file');

        $media = Media::create([
            'name' => $file->getClientOriginalName(),
            'file_name' => 'kartu_keluarga' . auth()->user()->nisn . $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'nisn' => auth()->user()->nisn,
            'author_id' => auth()->id()
        ]);

        // $directory = "media/{$media->created_at->format('Y/m/d')}/{$media->id}";
        $directory = "images/" . auth()->user()->nisn;
        $file->storeAs($directory, $media->file_name, 'public');

        return [
            'id' => $media->id,
            'preview_url' => $media->preview_url
        ];
    }
}
