<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'event_id',
        'description',
        'status',
        'event_time',
        'created_by',
        'updated_by',
        'deleted_by', // Add deleted_by to fillable fields
    ];

    // Soft delete configuration
    protected $dates = ['deleted_at'];

    

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function updater() {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public function deleter() {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    protected $casts = [
        'event_time' => 'datetime',
    ];
}
