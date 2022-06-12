<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;

class Slider extends Model
{
    use HasFactory, MediaAlly;

    protected $fillable = ['content'];
    protected $appends = ['image'];

    public function getImageAttribute() {
        $slider = Slider::where('id', $this->id)->first();
        return $slider->fetchFirstMedia() ? $slider->fetchFirstMedia() : (object)[];
    }
}
