<?php

declare(strict_types=1);


namespace App\Observers;

use App\Jobs\SendRegistrationEmailJob;
use App\Models\UserModel;

class UserObserver
{
    public function created(UserModel $user)
    {
        \dispatch(new SendRegistrationEmailJob($user));
    }
}
