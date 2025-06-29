<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;



class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category')
            ->when(
                $request->search,
                fn($q) =>
                $q->where('title', 'like', '%' . $request->search . '%')
            );

        $perPage = $request->per_page ?? 10;

        return Inertia::render('posts/Index', [
            'posts' => $query->paginate($perPage)->withQueryString(),
            'filters' => $request->only('search', 'per_page'),
        ]);
    }

    public function create()
    {
        return Inertia::render('posts/Create', [
            'categories' => Category::all(),
            'post' => null,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required',
            'category_id' => 'required',
        ]);
        Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'category_id' => $request->category_id,
            'thumbnails' => $request->thumbnails,
        ]);

        return to_route('posts.index')->with('success', 'Artikel berhasil disimpan!');
    }

    public function edit(Post $post)
    {
        return Inertia::render('posts/Edit', [
            'post' => $post,
            'categories' => Category::all(),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'thumbnails' => 'nullable|string',
        ]);

        // Hapus thumbnail lama jika ada thumbnail baru
        if (!empty($validated['thumbnails']) && $validated['thumbnails'] !== $post->thumbnails) {
            if ($post->thumbnails && Storage::exists($post->thumbnails)) {
                Storage::delete($post->thumbnails);
            }
            $post->thumbnails = $validated['thumbnails'];
        }

        $post->title = $validated['title'];
        $post->body = $validated['body'];
        $post->category_id = $validated['category_id'];
        $post->save();

        return to_route('posts.index')->with('success', 'Artikel berhasil diupdate!');
    }

    public function destroy(Post $post)
    {
        if ($post->thumbnails) {
            // Ambil path relatif dari URL
            $relativePath = str_replace(asset('storage') . '/', '', $post->thumbnails);

            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }

        // Hapus data post
        $post->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }

    public function uploadThumbnail(Request $request)
    {
        $request->validate([
            'thumbnail' => 'required|image|max:2048',
        ]);

        // Hapus thumbnail lama jika dikirim
        if ($request->has('oldThumbnail') && $request->oldThumbnail) {
            $oldPath = $request->oldThumbnail;
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // Simpan thumbnail baru ke disk 'public'
        $path = $request->file('thumbnail')->store('thumbnails', 'public');

        return response()->json(['path' => $path]);
    }
}
