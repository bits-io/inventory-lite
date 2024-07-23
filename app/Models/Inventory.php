<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'stock'];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
