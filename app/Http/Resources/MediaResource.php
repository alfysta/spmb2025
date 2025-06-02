<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request); {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'file_name' => $this->file_name,
                'mime_type' => $this->mime_type,
                'size' => $this->size,
                'author' => [
                    'id' => $this->author->id,
                    'name' => $this->author->name,
                ],
                'created_at' => $this->created_at->format('d/m/Y'),
                'preview_url' => $this->preview_url,
                'url' => $this->url,
            ];
        }
    }
}
