<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class pinjamruangController extends Controller
{
    public function index()
    {


        $rooms = Room::all(); // Retrieve all rooms from the database

        return view('pinjam-ruang', ['rooms' => $rooms]); // Pass the $rooms variable to the view
    }
}



