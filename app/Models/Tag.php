<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{

    use HasFactory;

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
