<?php

// app/Http/Controllers/FasilitasController.php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Item;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::with(['room', 'item'])->get();
        return view('fasilitas', ['fasilitas' => $fasilitas]);
    }

    public function create(Request $request)
    {
        $roomId = $request->input('ruang_id'); // Ambil room id dari request jika ada
        $room = Room::find($roomId); // Dapatkan room berdasarkan id
        $rooms = Room::all();
        $items = Item::all();

        return view('fasilitas-add', compact('room', 'rooms', 'items'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ruang_id'     => 'required',
            'barang_id'    => 'required',
            'JumlahBarang' => 'required|numeric',
        ], [
            'ruang_id.required' => 'Bidang Ruang wajib diisi.',
            'barang_id.required' => 'Bidang barang wajib diisi.',
            'JumlahBarang.required' => 'Bidang jumlah barang wajib diisi.',
            'JumlahBarang.numeric' => 'Bidang jumlah barang harus berupa angka.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Fasilitas::create([
            'ruang_id' => $request->ruang_id,
            'barang_id' => $request->barang_id,
            'JumlahBarang' => $request->JumlahBarang,
        ]);

        // return redirect()->route('fasilitas');

        return to_route('room-edit', $request->ruang_id);
    }
    public function edit($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $rooms = Room::all();
        $items = Item::all();

        return view('fasilitas-edit', compact('fasilitas', 'rooms', 'items'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ruang_id' => 'required',
            'barang_id' => 'required',
            'JumlahBarang' => 'required|numeric',
        ], [
            'ruang_id.required' => 'Bidang ruang wajib diisi.',
            'barang_id.required' => 'Bidang barang wajib diisi.',
            'JumlahBarang.required' => 'Bidang jumlah barang wajib diisi.',
            'JumlahBarang.numeric' => 'Bidang jumlah barang harus berupa angka.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->update([
            'ruang_id' => $request->ruang_id,
            'barang_id' => $request->barang_id,
            'JumlahBarang' => $request->JumlahBarang,
        ]);

        // return redirect()->route('fasilitas');

        return to_route('room-edit', $request->ruang_id);
    }

    public function destroy(Request $request, $id)
    {
        // $request->validate([
        //     'fasil_id' => 'required',
        // ]);

        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->delete();

        // return redirect()->route('fasilitas')->with('status', 'Fasilitas berhasil dihapus');

        // return to_route('room-edit', $request->fasil_id);
        return to_route('room-edit', $fasilitas->Room->id);
    }
}
