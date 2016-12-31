<?php

namespace NotificationChannels\Coolsms\Test;

use Mockery;
use NotificationChannels\Coolsms\Coolsms;
use NotificationChannels\Coolsms\CoolsmsChannel;
use NotificationChannels\Coolsms\CoolsmsMessage;
use Illuminate\Notifications\Notification;

class CoolsmsChannelTest extends \PHPUnit_Framework_TestCase
{
    protected $channel;

    protected $coolsms;

    protected $dispatcher;

    public function setUp()
    {
        parent::setUp();
        $this->coolsms = Mockery::mock(Coolsms::class);
        $this->coolsms->shouldReceive('from')->once();
        $this->channel = new CoolsmsChannel($this->coolsms);
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_will_send_a_sms_message_to_the_result_of_the_route_method_of_the_notifiable()
    {
        $notifiable = new NotifiableWithMethod();
        $notification = Mockery::mock(Notification::class);
        $message = new CoolsmsMessage('Message text');
        $notification->shouldReceive('toCoolsms')->andReturn($message);
        $this->coolsms->shouldReceive('sendMessage');
        $this->channel->send($notifiable, $notification);
    }
}

class NotifiableWithMethod
{
    public function routeNotificationFor()
    {
        return '5555555555';
    }
}
