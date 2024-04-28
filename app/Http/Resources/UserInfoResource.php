<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $imagePath = Storage::url($this->image);

        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "image" => $imagePath,
            "designation" => $this->designation,
            "mobile" => $this->mobile,
            "email_verified_at" => $this->email_verified_at,
            "remember_token" => $this->remember_token,
        ];
    }
}
