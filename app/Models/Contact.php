<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;

class Contact extends Model
{
    use HasFactory, MediaAlly;
    protected $fillable = ['name', 'phone'];
    protected $appends = ['image'];

    public function getImageAttribute() {
        $contact = Contact::where('id', $this->id)->first();
        return $contact->fetchFirstMedia();
    }
}
