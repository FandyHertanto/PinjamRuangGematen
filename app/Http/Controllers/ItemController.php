<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('item', ['items' => $items]);
    }

    public function add()
    {
        return view('item-add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'NamaBarang' => 'required|unique:items|max:100',
            'Deskripsi' => 'nullable|string'
        ]);

        Item::create([
            'NamaBarang' => $request->NamaBarang,
            'Deskripsi' => $request->Deskripsi
        ]);

        return redirect()->route('item')->with('status', 'Barang berhasil ditambah');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('item-edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaBarang' => 'required|unique:items,NamaBarang,' . $id,
            'Deskripsi' => 'nullable|string'
        ]);

        $item = Item::findOrFail($id);
        $item->update([
            'NamaBarang' => $request->NamaBarang,
            'Deskripsi' => $request->Deskripsi
        ]);

        return redirect()->route('item')
            ->with('status', 'Barang berhasil diubah');
    }
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('status', 'Barang berhasil dihapus');
    }
}
