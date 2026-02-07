<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Units;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with(['category', 'unit'])
                    ->latest()
                    ->paginate(10);

        $totalItems = Item::count();

        return view('inventory.items.index', compact('items', 'totalItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $units = Units::all();

        return view('inventory.items.form', compact('categories', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'unit_id' => 'required|exists:units,id',
        'quantity' => 'required|integer|min:1',
        'availability' => 'required|boolean',
        'description' => 'nullable|string',
        'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $validated['remaining'] = $validated['quantity'];
    $validated['created_by'] = Auth::id();
    $validated['updated_by'] = Auth::id();

    if ($request->hasFile('picture')) {
        $validated['picture'] = $request->file('picture')
                                        ->store('items', 'public');
    }

    Item::create($validated);

    // ✅ If AJAX request
    if ($request->ajax()) {

        $items = Item::with(['category','unit'])
                    ->latest()
                    ->paginate(10);

        return response()->json([
            'html' => view('inventory.items.table', compact('items'))->render(),
            'totalItems' => Item::count()
        ]);
    }

    return redirect()->route('items.index')
                     ->with('success', 'Item created successfully.');
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $categories = Category::all();
        $units = Units::all();

        return view('inventory.items.form', compact('item', 'categories', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'unit_id' => 'required|exists:units,id',
        'availability' => 'required|boolean',
        'description' => 'nullable|string',
        'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $validated['updated_by'] = Auth::id();

    if ($request->hasFile('picture')) {

        if ($item->picture) {
            Storage::disk('public')->delete($item->picture);
        }

        $validated['picture'] = $request->file('picture')
                                        ->store('items', 'public');
    }

    $item->update($validated);

    if ($request->ajax()) {

        $items = Item::with(['category','unit'])
                    ->latest()
                    ->paginate(10);

        return response()->json([
            'html' => view('inventory.items.table', compact('items'))->render(),
            'totalItems' => Item::count()
        ]);
    }

    return redirect()->route('items.index')
                     ->with('success', 'Item updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Item $item)
{
    if ($item->picture) {
        Storage::disk('public')->delete($item->picture);
    }

    $item->delete();

    if ($request->ajax()) {

        $items = Item::with(['category','unit'])
                    ->latest()
                    ->paginate(10);

        return response()->json([
            'html' => view('inventory.items.table', compact('items'))->render(),
            'totalItems' => Item::count()
        ]);
    }

    return redirect()->route('items.index')
                     ->with('success', 'Item deleted successfully.');
}
}
