<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {


        $rooms = Room::all(); // Retrieve all rooms from the database

        return view('home', ['rooms' => $rooms]); // Pass the $rooms variable to the view
    }
}

