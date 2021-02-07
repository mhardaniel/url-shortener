<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'original_link' => $this->original_link,
            'short_link' => env("APP_URL", "localhost"). '/'.$this->short_link,
            'created' => (string) $this->created_at,
        ];
    }
}
