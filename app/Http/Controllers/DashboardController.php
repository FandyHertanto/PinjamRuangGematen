<?php

namespace App\Http\Controllers;


use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $roomCount = Room::count();
        return view('dashboard', ['user_count'=> $userCount, 'room_count'=> $roomCount]);
    }
}
