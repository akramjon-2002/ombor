<?php

namespace App\Models;

class Client extends BaseModel
{
    protected $fillable = [
        'name',
        'phone',
        'address'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
