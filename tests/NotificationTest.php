<?php

use PHPUnit\Framework\TestCase;
use PinaNotifications\Messages\Message;
use PinaNotifications\Messages\MessageTemplate;
use PinaNotifications\Recipients\PhoneRecipient;
use PinaNotifications\Recipients\UserRecipient;
use PinaNotifications\Transports\StackExampleTransport;
use PinaNotifications\Transports\TransportRegistry;

class NotificationTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function test1()
    {
        $transport = new StackExampleTransport();
        TransportRegistry::set('phone', $transport);

        $text = 'Hello!';

        $message = new Message('', $text);
        $recipient = new PhoneRecipient('+712312341212');
        $recipient->notify($message);

        $this->assertEquals($transport->pop()->getText(), $text);
        $this->assertNull($transport->pop());

        $template = new MessageTemplate('', 'Hello, %name%');
        $recipient->notify($template->make(['name' => 'my darling']));

        $this->assertEquals($transport->pop()->getText(), 'Hello, my darling');
        $this->assertNull($transport->pop());

        $userRecipient = new UserRecipient(1);
        $userRecipient->notify($message);

        $this->assertEquals($transport->pop()->getText(), $text);
        $this->assertNull($transport->pop());
    }

}