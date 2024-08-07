<?php
namespace App\Http\Controllers;

use App\Models\Peminjaman; // Ensure you import the Peminjaman model
use Illuminate\Http\Request;

class AduanAdminController extends Controller
{
    public function index()
    {
        // Fetch the data you want to display, for example:
        $rents = Peminjaman::latest()->simplePaginate(25); // Adjust as needed

        // Pass the data to the view
        return view('admin-aduan', [
            'rents' => $rents
        ]);
    }
}
