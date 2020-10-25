<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupEmail2 extends Mailable
{
    use Queueable, SerializesModels;
    private $email_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('kashefymajid1992@gmail.com', env('APP_NAME'))->subject('خوش آمدید')->view('mail.signup2', ['email_data'=> 'h']);
    }
}
