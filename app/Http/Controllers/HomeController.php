<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('home', compact('rooms'));
    }

    public function detail($id)
    {
        $room = Room::with('fasilitas.item')->findOrFail($id);
        return view('detail-ruang', compact('room'));
    }
}
