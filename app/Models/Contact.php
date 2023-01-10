<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $fillable = [
        'firstname',
        'lastname',
        'patrony',
        'email',
        'phone',
    ];

    protected $hidden = ['pivot'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'tags_contacts','contact_id','tag_id');
    }

}
