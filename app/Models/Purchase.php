<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'quantity',
        'price'
    ];

    protected $appends = ['total'];

    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
