<?php

declare(strict_types=1);


namespace App\Mail;

use App\Models\UserModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public UserModel $user;

    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }

    public function build(): self
    {
        return $this->view('emails.RegistrationMail')
            ->subject('Registration')
            ->with([
                'name' => $this->user->name,
                'surname' => $this->user->surname,
                'email' => $this->user->email,
            ]);
    }
}
