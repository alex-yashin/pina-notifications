<?php

use PHPUnit\Framework\TestCase;
use PinaNotifications\Messages\Message;
use PinaNotifications\Messages\MessageTemplate;
use PinaNotifications\Messages\UrlTemplate;
use PinaNotifications\Recipients\PhoneRecipient;
use PinaNotifications\Recipients\UserRecipient;
use PinaNotifications\Recipients\UserNotifier;
use PinaNotifications\Transports\StackExampleTransport;
use PinaNotifications\Transports\TransportRegistry;

use Pina\App;
use Pina\Http\Location;
use Pina\Http\Url;

class NotificationTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function test1()
    {
        App::init('test', __DIR__ . '/config');

        $transport = new StackExampleTransport();
        TransportRegistry::set('phone', $transport);

        $text = 'Hello!';

        $message = new Message('', $text);
        $recipient = new PhoneRecipient('+712312341212');
        $recipient->notify($message);

        $this->assertEquals($message->getLink(), '');

        $this->assertEquals($transport->pop()->getText(), $text);
        $this->assertNull($transport->pop());

        $template = new MessageTemplate('', 'Hello, %name%');
        $recipient->notify($template->make(['name' => 'my darling']));

        $this->assertEquals($transport->pop()->getText(), 'Hello, my darling');
        $this->assertNull($transport->pop());

        $template = new MessageTemplate('', 'Hello, %name%');
        $template->setData(['name' => 'my darling']);
        $recipient->notify($template);

        $this->assertEquals($transport->pop()->getText(), 'Hello, my darling');
        $this->assertNull($transport->pop());

        $userRecipient = new UserRecipient(1);
        $userRecipient->notify($message);

        $this->assertEquals($transport->pop()->getText(), $text);
        $this->assertNull($transport->pop());

        $userNotifier = new UserNotifier();
        $userNotifier->notify(1, $message);

        $this->assertEquals($transport->pop()->getText(), $text);
        $this->assertNull($transport->pop());

        $template = new MessageTemplate('', 'Hello, %name%', new Url('http://yandex.ru'));
        $recipient->notify($m = $template->make(['name' => 'my darling']));

        $this->assertEquals(strval($transport->pop()->getLink()), 'http://yandex.ru');
        $this->assertNull($transport->pop());

        App::container()->set('base_url', new Location('', new Url('http://yandex.ru/')));

        $template = new MessageTemplate('', 'Hello, %name%', new UrlTemplate('products/:id', ['id' => '%product_id%']));
        $template->make(['name' => 'my darling', 'product_id' => 5]);
        $recipient->notify($m = $template->make(['name' => 'my darling', 'product_id' => 5]));

        $this->assertEquals(strval($transport->pop()->getLink()), 'http://yandex.ru/products/5');
        $this->assertNull($transport->pop());

    }

}