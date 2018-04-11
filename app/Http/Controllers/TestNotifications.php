<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class TestNotifications extends Controller
{
    /**
     * In this case $token its hardcoded for testing
     */

    public function sendToOneDevice(){
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

        $token ="cw-sE-vhARE:APA91bEMPzwPTz79xnRqpv3qPfXoWat6MqzguVqEiPTybnfWjdyKBRqmCDvTZuB7RdSobNasR-5P2YKmKrIgmCDbIYpNRN6PXy2ckNsQpoXxAItsmy78cCEgHDOjfqQb65Og8TQzMzrS";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
    }

    public function sendToMultipleDevices(){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        // You must change it to get your tokens
        $tokens = MYDATABASE::pluck('fcm_token')->toArray();

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();
    }
}
