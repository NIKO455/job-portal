<?php

namespace App\Http\Resources;

use App\Models\SavedJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class JobPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $saved_post = SavedJob::where('job_post_id', $this->id)->where('user_id', Auth::id())->first();

        return [
            "id" => $this->id,
            "title" => $this->title,
            "slug" => $this->slug,
            "category_id" => $this->category,
            "job_type_id" => $this->jobType,
            "status" => $this->status,
            "user_id" => $this->user,
            "vacancy" => $this->vacancy,
            "salary" => $this->salary,
            "location" => $this->location,
            "description" => $this->description,
            "benefits" => $this->benefits,
            "responsibility" => $this->responsibility,
            "qualification" => $this->qualification,
            "keywords" => $this->keywords,
            "experience" => $this->experience,
            "company_name" => $this->company_name,
            "company_location" => $this->company_location,
            "company_website" => $this->company_website,
            "created_at" => Carbon::parse($this->created_at)->format("d M, Y"),
            "updated_at" => $this->updated_at,
            "application_count" => $this->JobApplication ? $this->JobApplication->count() : null,
            "saved_post" => (bool)$saved_post,
        ];
    }
}
