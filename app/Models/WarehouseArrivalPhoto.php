<?php

namespace App\Models;

class WarehouseArrivalPhoto extends BaseModel
{
    protected $fillable = [
        'warehouse_arrival_id',
        'file_path',
        'original_filename',
        'mime_type',
        'file_size',
        'ai_recognition_data',
        'description'
    ];

    protected $casts = [
        'file_size' => 'integer',
        'ai_recognition_data' => 'array'
    ];

    public function warehouseArrival()
    {
        return $this->belongsTo(WarehouseArrival::class);
    }
}
