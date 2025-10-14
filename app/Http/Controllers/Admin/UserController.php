<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query', '');
        $users = User::query()
            ->where('first_name', 'like', "%{$query}%")
            ->where('last_name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'first_name', 'last_name', 'email', 'phone']);

        return response()->json($users);
    }
}
