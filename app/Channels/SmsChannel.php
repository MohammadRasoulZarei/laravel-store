<?php

namespace App\Channels;


use Ghasedak\Laravel\GhasedakFacade;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($user, Notification $notification)
    {

        GhasedakFacade::setVerifyType(GhasedakFacade::VERIFY_MESSAGE_TEXT)
        ->Verify(
            $user->cellphone,
            "test",
            $notification->code,
        );
    }
}
