<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;


class MessageLogController extends Controller
{
    /**
     * Display a listing of message-related audit logs.
     */
    public function index(Request $request)
    {
        $query = AuditLog::query()
            ->whereIn('model_type', [
                \App\Models\Message::class,
                \App\Models\MessageContact::class,
            ])
            ->with('user') // if your AuditLog has a user() relationship
            ->latest();

        // Optional filtering
        if ($search = $request->get('search')) {
            $query->where('description', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%");
        }

        if ($action = $request->get('action')) {
            $query->where('action', $action);
        }

        $logs = $query->paginate(15);

        return view('admin.messages.logs.index', compact('logs'));
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

        return view('admin.messages.logs.show', compact('log'));
    }


    public function showActivityLog($id)
    {
        $log = AuditLog::with('user')->findOrFail($id);

        return view('admin.messages.logs.show', compact('log'));
    }
}
