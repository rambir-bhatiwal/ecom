<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attributes';
    protected $fillable = ['name', 'slug'];

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'id', 'attribute_id');
    }
}
