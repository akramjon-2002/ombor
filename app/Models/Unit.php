<?php

namespace App\Models;

class Unit extends BaseModel
{
    protected $fillable = [
        'name',
        'short_name'
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
