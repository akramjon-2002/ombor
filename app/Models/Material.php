<?php

namespace App\Models;

class Material extends BaseModel
{
    protected $fillable = [
        'name',
        'category_id',
        'unit_id',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function stock()
    {
        return $this->hasMany(WarehouseStock::class);
    }
}
