<?php

namespace NotificationChannels\Coolsms;

use Illuminate\Notifications\Notification;

class CoolsmsChannel
{
    /**
     * @var Coolsms Api instance.
     */
    protected $coolsms;

    /**
     * The phone number notifications should be sent from.
     *
     * @var string
     */
    protected $from;

    /**
     * CoolsmsChannel constructor.
     *
     * @param Coolsms $coolsms
     * @param  string  $from
     * @return void
     */
    public function __construct(Coolsms $coolsms)
    {
        $this->coolsms = $coolsms;
        $this->from = $this->coolsms->from();
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification  $notification
     * @return \NotificationChannels\Coolsms\CoolsmsMessage
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('coolsms')) {
            return;
        }

        $message = $notification->toCoolsms($notifiable);

        if (is_string($message)) {
            $message = new CoolsmsMessage($message);
        }

        return $this->coolsms->sendMessage([
            'type' => $message->type,
            'from' => $message->from ?: $this->from,
            'to' => $to,
            'text' => trim($message->content),
        ]);
    }
}
