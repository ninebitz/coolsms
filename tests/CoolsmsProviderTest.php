<?php

namespace NotificationChannels\Coolsms\Test;

use Mockery;
use ArrayAccess;
use NotificationChannels\Coolsms\Coolsms;
use NotificationChannels\Coolsms\CoolsmsChannel;
use NotificationChannels\Coolsms\CoolsmsServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class CoolsmsProviderTest extends \PHPUnit_Framework_TestCase
{
    protected $provider;

    protected $app;

    public function setUp()
    {
        parent::setUp();
        $this->app = Mockery::mock(App::class);
        $this->provider = new CoolsmsServiceProvider($this->app);
        $this->app->shouldReceive('make')->andReturn(Mockery::mock(Coolsms::class));
        $this->app->shouldReceive('flush');
    }

    /** @test */
    public function it_gives_an_instantiated_coolsms_object_when_the_channel_asks_for_it()
    {
        $this->app->shouldReceive('offsetGet')
            ->with('config')
            ->andReturn([
                'services.coolsms' => [
                    'key' => 'key',
                    'secret' => 'secret',
                    'sms_from' => '01011112222',
                ],
            ]);

        $this->app->shouldReceive('when')->with(CoolsmsChannel::class)->once()->andReturn($this->app);
        $this->app->shouldReceive('needs')->with(Coolsms::class)->once()->andReturn($this->app);
        $this->app->shouldReceive('give')->with(Mockery::on(function ($coolsms) {
            return $coolsms() instanceof Coolsms;
        }))->once();
        $this->provider->boot();
    }
}

interface App extends Application, ArrayAccess
{
}
