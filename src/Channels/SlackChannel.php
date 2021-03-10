<?php

namespace Ant\Notifications\Channels;

use Illuminate\Notifications\Notification;

class SlackChannel
{
    protected $client;
    protected $optional;

    /**
     * @param $optional catch exception when true 
     */
    public function __construct($client, $optional = false)
    {
        $this->client = $client;
        $this->optional = $optional;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSlack($notifiable);

        try {
            // Send notification to the $notifiable instance...
            // This method requires your token to have the scope "chat:write"
            $map = [
                'username' => 'username',
                'icon_emoji' => 'icon',
                'channel' => 'channel',
                'text' => 'content',
            ];
            foreach ($map as $from => $to) {
                if (isset($message->{$to})) {
                    $data[$from] = $message->{$to};
                }
            }
            $result = $this->client->chatPostMessage($data);
        } catch (\JoliCode\Slack\Exception\SlackErrorResponse $e) {
            if (!$this->optional) throw $e;
        }
    }
}