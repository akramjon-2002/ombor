<?php

namespace App\Models;

class Category extends BaseModel
{
    protected $fillable = [
        'name'
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
