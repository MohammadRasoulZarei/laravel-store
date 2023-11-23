<?php

namespace App\Channels;



use Ghasedak\Laravel\GhasedakFacade;
use Illuminate\Notifications\Notification;

class PaymentSmsChannel
{
    public function send($user, Notification $notification)
    {

        $time=verta($notification->date)->format('H:i');
        $date=verta($notification->date)->format('y/n/j');
  //  dd($date);
        GhasedakFacade::setVerifyType(GhasedakFacade::VERIFY_MESSAGE_TEXT)
        ->Verify(
            $user->cellphone,
            "paymentRecipt",
            $notification->amount,
            $notification->refId,
            $date,
            $time,
        );
    }
}
