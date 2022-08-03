<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;
    protected $hidden = ['title', 'description', 'created_at', 'updated_at', 'deleted_at'];
    public $translatable = ['title', 'description'];
    protected $fillable = ['title', 'description', 'price', 'color', 'period', 'contacts_number'];
    protected $appends = ['name', 'details'];

    
    public function getDetailsAttribute(): string
    {
        return $this->description;
    }

    public function getNameAttribute(): string
    {
        return $this->title;
    }
}
