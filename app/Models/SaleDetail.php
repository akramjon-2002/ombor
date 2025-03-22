<?php

namespace App\Models;

class SaleDetail extends BaseModel
{
    protected $fillable = [
        'sale_id',
        'batch_id',
        'material_id',
        'quantity',
        'price_per_unit',
        'total_price'
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'price_per_unit' => 'decimal:2',
        'total_price' => 'decimal:2'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function returns()
    {
        return $this->hasMany(ReturnModel::class);
    }
}
