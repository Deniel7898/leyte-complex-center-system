<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Units;

class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'availability',
        'quantity',
        'remaining',
        'picture',
        'category_id',
        'unit_id',
        'created_by',
        'updated_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Item belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Item belongs to Units
    public function unit()
    {
        return $this->belongsTo(Units::class);
    }

    // Item has many Consumable Inventories
    public function inventoryConsumables()
    {
        return $this->hasMany(InventoryConsumable::class);
    }

    // Item has many Non-Consumable Inventories
    public function inventoryNonConsumables()
    {
        return $this->hasMany(InventoryNonConsumable::class);
    }

    // Item belongs to many Purchase Requests (through pivot table)
    public function purchaseRequests()
    {
        return $this->belongsToMany(
            PurchaseRequest::class,
            'items_purchase_request'
        )->withPivot('description', 'quantity')
         ->withTimestamps();
    }
}
