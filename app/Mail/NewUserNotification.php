<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from('no-reply@yourdomain.com')
                    ->subject($this->data['subject'])
                    ->text('emails.new_user_notification')
                    ->with('data', $this->data);
    }
}
