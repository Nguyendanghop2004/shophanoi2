<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorieAdmins extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'action',
        'model_type',
        'model_id',
        'changes'
    ];
    protected $casts = [
        'changes' => 'array', // Chuyển trường 'changes' thành dạng array
    ];
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
