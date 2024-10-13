<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'address',
        'created_by',
        'updated_by',
        'deleted_by',
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
}
