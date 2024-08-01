<?php
// app/Http/Controllers/FeedbackController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackMail;

class FeedbackController extends Controller
{
    public function sendFeedbackEmail(Request $request)
    {
        // Your email sending logic here

        // Return JSON response
        return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim.']);
    }
}
