<?php

namespace App\Services;

use App\Models\AuditLog;

class AuditLogService
{
    public function log(string $action, $model, array $data = [],  $description = null)
    {
        AuditLog::create([
            'action'       => $action,
            'model_type'   => get_class($model),
            'model_id'     => $model->getKey(),
            'admin_id'      => auth('admin')->id(),
            'old_data'     => $data['old'] ?? null,
            'new_data'     => $data['new'] ?? null,
            'description'  => $description,
        ]);
    }
}
