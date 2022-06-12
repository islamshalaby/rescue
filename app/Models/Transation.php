<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'package_id', 'price'];

    public function _package() {
        return $this->belongsTo('App\Models\Package', 'package_id');
    }
}
