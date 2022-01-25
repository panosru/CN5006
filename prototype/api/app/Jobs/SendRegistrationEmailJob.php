<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Mail\RegistrationEmail;
use App\Models\UserModel;
use Illuminate\Support\Facades\Mail;

class SendRegistrationEmailJob extends Job
{
    private UserModel $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new RegistrationEmail($this->user));
    }
}
