<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;


class MessageSentController extends Controller
{
    /**
     * Display a listing of message-related audit logs.
     */
    public function index(Request $request)
    {
        $query = AuditLog::query()
            ->whereIn('model_type', [
                \App\Models\Message::class,
            ])
            ->whereRaw('LOWER(action) LIKE ?', ['%send%'])
            ->with('user') // if your AuditLog has a user() relationship
            ->latest();

        // Optional filtering
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereDate('created_at', $search);
            });
        }

        if ($action = $request->get('action')) {
            $query->where('action', $action);
        }

        $logs = $query->paginate(15)->appends($request->query());
        

        return view('admin.messages.sent.index', compact('logs'));
    }

    /**
     * Display a single audit log entry in detail.
     */
    public function show($id)
    {
        $log = AuditLog::with('user')->findOrFail($id);

        abort_unless(
            in_array($log->model_type, [\App\Models\Message::class, \App\Models\MessageContact::class]),
            404,
            'Invalid log type.'
        );

        return view('admin.messages.sent.show', compact('log'));
    }


    public function showActivityLog($id)
    {
        $log = AuditLog::with('user')->findOrFail($id);

        return view('admin.messages.sent.show', compact('sent'));
    }
}
