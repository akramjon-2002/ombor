<?php

namespace App\Models;

class Warehouse extends BaseModel
{
    protected $fillable = [
        'name',
        'location'
    ];

    public function stock()
    {
        return $this->hasMany(WarehouseStock::class);
    }

    public function arrivals()
    {
        return $this->hasMany(WarehouseArrival::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
