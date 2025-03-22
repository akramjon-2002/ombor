<?php

namespace App\Models;

class Batch extends BaseModel
{
    protected $fillable = [
        'material_id',
        'supplier_id',
        'batch_number',
        'serial_number',
        'quantity',
        'arrival_date',
        'expiration_date',
        'status'
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'expiration_date' => 'date',
        'quantity' => 'decimal:3'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouseArrivals()
    {
        return $this->hasMany(WarehouseArrival::class);
    }

    public function stock()
    {
        return $this->hasMany(WarehouseStock::class);
    }

    public function salesDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function returns()
    {
        return $this->hasMany(ReturnModel::class);
    }
}
