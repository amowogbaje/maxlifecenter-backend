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
            ->with('admin') // if your AuditLog has a admin() relationship
            ->latest();

        // Optional filtering
        $search = $request->input('search');
        if ($search) {
            $normalizedDate = null;

            try {
                $timestamp = strtotime($search);
                if ($timestamp !== false) {
                    $normalizedDate = date('Y-m-d', $timestamp);
                }
            } catch (\Exception $e) {
                $normalizedDate = null;
            }

            $query->where(function ($q) use ($search, $normalizedDate) {
                $q->where('action', 'like', "%{$search}%")
                ->orWhereHas('admin', function ($userQuery) use ($search) {
                    $userQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                });

                if (!empty($normalizedDate)) { // ✅ safer null/empty check
                    $q->orWhereDate('created_at', $normalizedDate);
                }
            });
        }

        $logs = $query->paginate(15)->appends($request->query());

        return view('admin.messages.logs.index', compact('logs'));
    }

    /**
     * Display a single audit log entry in detail.
     */
    public function show($id)
    {
        $log = AuditLog::with('admin')->findOrFail($id);

        abort_unless(
            in_array($log->model_type, [\App\Models\Message::class, \App\Models\MessageContact::class]),
            404,
            'Invalid log type.'
        );

        return view('admin.messages.logs.show', compact('log'));
    }


    public function showActivityLog($id)
    {
        $log = AuditLog::with('admin')->findOrFail($id);

        return view('admin.messages.logs.show', compact('log'));
    }

    public function activityLogs(Request $request) 
    {
        $search = $request->input('search');
        $query = AuditLog::with('admin')->latest();

        if ($search) {
            $normalizedDate = null;

            try {
                $timestamp = strtotime($search);
                if ($timestamp !== false) {
                    $normalizedDate = date('Y-m-d', $timestamp);
                }
            } catch (\Exception $e) {
                $normalizedDate = null;
            }

            $query->where(function ($q) use ($search, $normalizedDate) {
                $q->where('action', 'like', "%{$search}%")
                ->orWhereHas('admin', function ($userQuery) use ($search) {
                    $userQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                });

                if (!empty($normalizedDate)) { // ✅ safer null/empty check
                    $q->orWhereDate('created_at', $normalizedDate);
                }
            });
        }


        $activityLogs = $query->paginate(10)->appends($request->query());
        return view('admin.messages.logs.activity_logs', compact('activityLogs'));
    }
}
