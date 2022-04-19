<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, HasTranslations;
    protected $fillable = ['phone', 'terms_conditions', 'about_app', 'app_name', 'show_buy'];
    public $translatable = ['terms_conditions', 'about_app', 'app_name'];

}
