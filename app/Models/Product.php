<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'quantity'];

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sales_products')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
