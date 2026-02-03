<?php

namespace App\Models;

use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Helpers\EditorJsParser;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'body' => 'array',
    ];


    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getExcerptAttribute(): string
    {
        if (!is_array($this->body) || empty($this->body['blocks'])) {
            return '';
        }

        $text = collect($this->body['blocks'])
            ->map(function ($block) {
                $type = $block['type'] ?? null;
                $data = $block['data'] ?? [];

                return match ($type) {
                    'paragraph',
                    'header',
                    'quote' => $data['text'] ?? '',

                    'list' => implode(' ', $data['items'] ?? []),

                    'checklist' => collect($data['items'] ?? [])
                        ->pluck('text')
                        ->implode(' '),

                    'code' => $data['code'] ?? '',

                    default => '',
                };
            })
            ->filter()
            ->implode(' ');

        return Str::limit(
            trim(strip_tags($text)),
            100
        );
    }

    public function getBodyHtmlAttribute(): string
    {
        return EditorJsParser::parse($this->body ?? []);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

}
