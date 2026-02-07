<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class InventoryController extends Controller
{
    /**
     * Display a listing of the inventory (consumable & non-consumable items).
     */
    public function index()
    {
        // Get all items grouped by type (consumable/non-consumable)
        $items = Item::with(['category', 'unit'])
                    ->latest()
                    ->paginate(10);

        $totalItems = Item::count();
        $totalQuantity = Item::sum('quantity');
        $totalRemaining = Item::sum('remaining');

        return view('inventory.inventory.index', compact('items', 'totalItems', 'totalQuantity', 'totalRemaining'));
    }
}
