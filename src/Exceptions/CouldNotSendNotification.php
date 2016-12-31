<?php

namespace NotificationChannels\Coolsms\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static("Descriptive error message.");
    }

    public static function commonError($message)
    {
        return new static($message);
    }
}
