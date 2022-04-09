<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;

class EmergencyMessage extends Model
{
    use HasFactory, MediaAlly;
    protected $fillable = ['user_id', 'name', 'phone', 'message', 'image'];
}
