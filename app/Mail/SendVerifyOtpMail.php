<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendVerifyOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        $name = $this->data['name'];
        $otp = $this->data['otp'];
        $subject = 'Send Verify OTP Successfully';

        return $this->view('emails.send_otp_verify_mail',
            compact('name', 'otp'))
            ->markdown('emails.send_otp_verify_mail')
            ->subject($subject);
    }
}
