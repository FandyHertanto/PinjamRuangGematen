<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $itemId;
    public $message;

    public function __construct($itemId, $message)
    {
        $this->itemId = $itemId;
        $this->message = $message;
    }

    public function build()
    {
        return $this->view('emails.feedback')
            ->subject('Feedback Message')
            ->with([
                'itemId' => $this->itemId,
                'messageBody' => $this->message,
            ]);
    }
}
