<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBanner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'link',
        'description',
        'btn_text',
        'btn_link',
        'status',
    ];
}
