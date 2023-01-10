<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactTag extends Model
{

    protected $table = "tags_contacts";

    protected $fillable = [
        'tag_id',
        'contact_id',
    ];


    public function tag()
    {
        //return $this->belongsTo(Tag::class,'tag_id','id');
    }

    public function contact()
    {
        //return $this->belongsTo(Contact::class,'contact_id','id');
    }
}
