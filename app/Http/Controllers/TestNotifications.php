<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class TestNotifications extends Controller
{
    public function send()
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('Mensaje desde el olimpo');
        $notificationBuilder->setBody('Hola Perros')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "cPmdOQiHkoI:APA91bH7Ae14xx0f5OPpX0QlAOupo6zauVjUqr1xJv2utfvbHcog0Vlq8ZPP3iaun8so-KSyatZ1B6ZzgZWhOp7ntSb8suy4JWiEQRWWL-ojsN0zunTJJidmEP4P8ZiXcYuxGjqnJkVW";
        //$token = "d3Twtn-BeJQ:APA91bGVKUTHoxQafojD0rk7pjqwV7B-Jfjpt_muy3dsU7-rO9hOyfZjy0CYP9mw7xvlck85HEoht0XGDg9U5bsqs-Y6EbkNanJUjbnTE_clTAiMYcg_hnJAqnBSOO7E0jMRLVC3M_Gg";

        //$downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
    }
}
