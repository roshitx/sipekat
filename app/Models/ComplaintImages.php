<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'image_path'
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
