<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyMessage extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'contact_id', 'message'];

    public function contact() {
        return $this->belongsTo('App\Models\Contact', 'contact_id')->select('id', 'name', 'phone');
    }
}
