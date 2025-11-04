<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function roles(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('currentReward') // eager load for performance
            ->where('is_admin', false)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    // Basic text fields
                    $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");

                    // Numeric or partial match fields
                    if (is_numeric($search)) {
                        $q->orWhere('bonus_point', $search)
                        ->orWhere('total_spent', $search);
                    } else {
                        // Handle fuzzy number search (e.g., "1000" matches "1000.50")
                        $q->orWhere('bonus_point', 'like', "%{$search}%")
                        ->orWhere('total_spent', 'like', "%{$search}%");
                    }

                    
                    $q->orWhereHas('currentReward', function ($tierQuery) use ($search) {
                        $tierQuery->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.role', compact('users'));
    }
}
