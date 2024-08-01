<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();

        // $rooms =  Room::with('Fasilitas')->get();
        // $rooms = Room::with(['Fasilitas'])->get();

        return view('room', [
            'rooms' => $rooms
        ]);

        // return view('room', compact('rooms'));
    }

    public function create()
    {
        return view('room-add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaRuang' => 'required',
            'Kapasitas' => 'required',
            'Gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $input = $request->all();

        if ($Gambar = $request->file('Gambar')) {
            $destionationPath = 'Gambar/';
            $profileGambar = date('YmdHis') . "." . $Gambar->getClientOriginalextension();
            $Gambar->move($destionationPath, $profileGambar);
            $input['Gambar'] = $profileGambar;
        }
        Room::create($input);

        return redirect()->route('room')
            ->with('success', 'Ruang berhasil ditambah');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);

        // $room = Room::findOrFail(1);

        $fasilitas = Fasilitas::where('ruang_id', $room->id)->get();

        // return view('room-edit', compact('room'));

        // dd($room->Fasilitas->Item);

        return view('room-edit', [
            'room'      => $room,
            'fasilitas' => $fasilitas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaRuang' => 'required',
            'Kapasitas' => 'required',
            'Gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // ubah validasi untuk gambar
        ]);

        $room = Room::findOrFail($id);
        $input = $request->all();

        if ($Gambar = $request->file('Gambar')) {
            $destinationPath = 'Gambar/';
            $profileGambar = date('YmdHis') . "." . $Gambar->getClientOriginalExtension();
            $Gambar->move($destinationPath, $profileGambar);
            $input['Gambar'] = $profileGambar;
        } else {
            unset($input['Gambar']);
        }

        $room->update($input); // perbarui data ruangan
        return redirect()->route('room')->with('success', 'Ruang berhasil diubah');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id); // Find the room by ID

        // Check if the room has related facilities and delete them
        if ($room->Fasilitas->count()) {
            $room->Fasilitas()->delete(); // Delete all related facilities
        }

        // Check if the image exists and delete it
        $gambarPath = public_path('Gambar/' . $room->Gambar);
        if (file_exists($gambarPath)) {
            unlink($gambarPath); // Delete the image file
        }

        // Delete the room
        $room->delete();

        // Redirect back with success message
        return redirect()->route('room')->with('success', 'Ruang berhasil dihapus');
    }
}
