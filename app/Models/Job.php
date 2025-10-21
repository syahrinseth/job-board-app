<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_lists';

    protected $fillable = [
        'title',
        'company',
        'location',
        'description',
        'requirements',
        'salary_range',
        'job_type',
        'work_type',
        'owner_id',
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
