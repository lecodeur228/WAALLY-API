<?php

namespace App\Helpers;

use Twilio\Rest\Client;


class SendSmsTwilio
{

    static public function sendSms($phoneNumber, $message)
    {
        $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));

        $message = $client->messages->create(
            $phoneNumber,
            [

                'from' =>  env('TWILIO_PHONE_NUMBER'),
                'body' => $message,
            ]
        );

        return $message;
    }

}
