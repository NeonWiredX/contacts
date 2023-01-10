<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $fillable = [
        'text',
        'color',
    ];

    protected $hidden = ['pivot'];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class,'tags_contacts','tag_id','contact_id');
    }
}
