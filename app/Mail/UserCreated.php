<?php

namespace App\Mail;

use App\User;
use App\Http\Controller\RegisterController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->email_data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('jintu.panackakuzhy@gmail.com', name:'sample.com')->subject("Welcome to Coderaweso.me!")->view('emails.welcome', ['email_data' => $this->email_data]);
    }
}
