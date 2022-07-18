<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;

class Contact extends Model
{
    use HasFactory, MediaAlly;
    protected $fillable = ['name', 'phone', 'user_id'];
    protected $appends = ['image'];

    public function getImageAttribute() {
        $contact = Contact::where('id', $this->id)->first();
        return $contact->fetchFirstMedia() ? $contact->fetchFirstMedia() : (object)[];
    }

    public function emergency() {
        return $this->hasOne('App\Models\EmergencyMessage', 'contact_id');
    }
}
