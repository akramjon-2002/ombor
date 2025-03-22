<?php

namespace App\Models;

class Sale extends BaseModel
{
    protected $fillable = [
        'client_id',
        'user_id',
        'warehouse_id',
        'sale_date',
        'status'
    ];

    protected $casts = [
        'sale_date' => 'date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function returns()
    {
        return $this->hasMany(ReturnModel::class);
    }
}
