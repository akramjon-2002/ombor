<?php

namespace App\Models;

class WarehouseStock extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'batch_id',
        'material_id',
        'warehouse_id',
        'quantity'
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'last_updated' => 'datetime'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
