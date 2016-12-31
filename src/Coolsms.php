<?php

namespace NotificationChannels\Coolsms;

use Nurigo\Coolsms as CoolsmsApi;
use NotificationChannels\Coolsms\Exceptions\CouldNotSendNotification;

class Coolsms extends CoolsmsApi
{
    /**
     * Default 'from'.
     * @var string
     */
    protected $from;

    /**
     * Coolsms constructor.
     *
     * @param  array  $config
     */
    public function __construct(array $config)
    {
        $this->from = $config['sms_from'];

        parent::__construct($config['key'], $config['secret']);
    }

    /**
     * Send a CoolsmsMessage to the a phone number.
     *
     * @param  array  $options
     * @return mixed
     * @throws CouldNotSendNotification
     */
    public function sendMessage(array $options)
    {
        $options = json_decode(json_encode($options));

        try {
            return $this->request('send', $options, true);
        } catch (\Exception $e) {
            throw CouldNotSendNotification::commonError($e->getMessage());
        }
    }

    /**
     * Number SMS is being sent from.
     *
     * @return string
     */
    public function from()
    {
        return $this->from;
    }
}