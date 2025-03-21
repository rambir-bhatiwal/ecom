<?php

namespace App\Models;

use Dom\Attr;
use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{
    protected $table = 'category_attribute';
    protected $fillable = ['category_id', 'attribute_id']; 

    public function attribute(){
        return $this->hasOne(Attribute::class, 'id','attribute_id');
    }

    public function category(){
        return $this->hasOne(Category::class, 'id','category_id');
    }
}