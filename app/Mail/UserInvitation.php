<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $mail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        return $this->from($this->mail->sender_email)->view('layouts.email.email_invitation_template')->with(['sender_email' => $this->mail->sender_email, 'sender_name' => $this->mail->sender_name,
            'receiver_email' => $this->mail->receiver_email, 'receiver_name' => $this->mail->receiver_name, 'token' => $this->mail->token, 'hostname' => $request->getHttpHost()]);
    }
}
