<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
      */
    public $name;
    public $email;
    public $subject;
    public $message;

    // public function __construct($details)
    // {
    //      $this->$details = $details;
    // }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->from('bot@e-earners.com')
        ->subject($this->subject)
        ->markdown('sendmail')->with([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message

        ]);
    }
}
