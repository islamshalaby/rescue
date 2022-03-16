<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public $translatable = ['title', 'description'];
    protected $fillable = ['title', 'description', 'price', 'color', 'period'];

    
    public function getDescriptionAttribute($value): string
    {
        $lang = app()->getLocale();
        return json_decode($value, true)[$lang];
    }

    public function getTitleAttribute($value): string
    {
        $lang = app()->getLocale();
        return json_decode($value, true)[$lang];
    }
}
