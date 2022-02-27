<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['title', 'description'];
    protected $fillable = ['titla', 'description', 'price', 'color'];
}
