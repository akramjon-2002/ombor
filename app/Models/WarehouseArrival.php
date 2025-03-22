<?php

namespace App\Models;

class WarehouseArrival extends BaseModel
{
    protected $fillable = [
        'batch_id',
        'warehouse_id',
        'user_id',
        'quantity',
        'arrival_date',
        'status'
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'quantity' => 'decimal:3'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(WarehouseArrivalPhoto::class);
    }
}
