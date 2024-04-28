<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "category_id",
        "job_type_id",
        "vacancy",
        "salary",
        "location",
        "description",
        "benefits",
        "responsibility",
        "qualification",
        "keywords",
        "experience",
        "company_name",
        "company_location",
        "company_website",
        "slug",
        "user_id"
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function JobApplication(){
        return $this->hasMany(JobApplication::class);
    }

}
