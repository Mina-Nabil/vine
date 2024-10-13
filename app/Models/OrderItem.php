<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = "order_items";
    public $timestamps = false;

    public $fillable = [
        "inventory_id", "amount" 
    ];
    public $attributes = [
        "amount" => 0
    ];

    public function order()
    {
        return $this->belongsTo("App\Models\Order", "order_id", "id");
    }

    public function inventory()
    {
        return $this->belongsTo("App\Models\Inventory", "inventory_id", "id");
    }
}
