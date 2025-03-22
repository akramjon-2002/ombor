<?php

namespace App\Models;

class ReturnModel extends BaseModel
{
    protected $table = 'returns';

    protected $fillable = [
        'sale_detail_id',
        'batch_id',
        'material_id',
        'warehouse_id',
        'user_id',
        'quantity',
        'return_date',
        'reason'
    ];

    protected $casts = [
        'return_date' => 'date',
        'quantity' => 'decimal:3'
    ];

    public function saleDetail()
    {
        return $this->belongsTo(SaleDetail::class);
    }

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
