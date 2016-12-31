<?php

namespace NotificationChannels\Coolsms\Test;

use NotificationChannels\Coolsms\CoolsmsMessage;

class CoolsmsMessageTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_accept_a_content_when_constructing_a_message()
    {
        $message = new CoolsmsMessage('hello');

        $this->assertEquals('hello', $message->content);
    }

    /** @test */
    public function it_can_accept_a_content_when_creating_a_message()
    {
        $message = CoolsmsMessage::create('hello');

        $this->assertEquals('hello', $message->content);
    }

    /** @test */
    public function it_can_set_the_content()
    {
        $message = (new CoolsmsMessage())->content('hello');

        $this->assertEquals('hello', $message->content);
    }

    /** @test */
    public function it_can_set_the_from()
    {
        $message = (new CoolsmsMessage())->from('11122223333');

        $this->assertEquals('11122223333', $message->from);
    }
}