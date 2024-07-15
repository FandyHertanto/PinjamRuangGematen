<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from('fandy.hertanto@ti.ukdw.ac.id', 'Peminjaman Ruang Gematen')
                    ->subject($this->data['subject'])
                    ->view('email')
                    ->with('data', $this->data);
    }
}
