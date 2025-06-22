<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // default 10

        $users = User::query()
            ->when($search, fn($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('nisn', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('users/Index', [
            'users' => $users,
            'filters' => [
                'search' => $search,
                'per_page' => $perPage
            ]
        ]);
    }
}
