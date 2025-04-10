<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Product;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'total', 'is_closed'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sales_products')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
