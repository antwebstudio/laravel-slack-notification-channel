<?php

namespace Ant\Notifications;

use Illuminate\Support\ServiceProvider;

class SlackChannelServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        \Illuminate\Support\Facades\Notification::resolved(function (\Illuminate\Notifications\ChannelManager $service) {
            $service->extend('slack', function ($app) {
                $client = \JoliCode\Slack\ClientFactory::create(config('services.slack.bot_token'));
                return new \Ant\Notifications\Channels\SlackChannel($client);
            });
        });
    }
}