<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'admin_id'   => $this->admin_id,
            'title'      => $this->title,
            'slug'       => $this->slug,

            'excerpt'    => $this->excerpt,

            // Parsed HTML (accessor)
            'body_html'  => $this->body_html,

            'image'      => asset($this->image) ?? null,
            'status'     => $this->status,
            'featured'   => (bool) $this->featured,

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'deleted_at' => $this->deleted_at?->toISOString(),

            'categories' => CategoryResource::collection(
                $this->whenLoaded('categories')
            ),

            'admin' => new AdminResource(
                $this->whenLoaded('admin')
            ),
        ];
    }
}