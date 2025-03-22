<?php

namespace App\Models;

class Supplier extends BaseModel
{
    protected $fillable = [
        'name',
        'contact_info'
    ];

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
