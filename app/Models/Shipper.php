<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date_of_birth', 'phone', 'hometown', 'profile_picture', 'email'];
}
