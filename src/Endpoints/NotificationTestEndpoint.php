<?php


namespace PinaNotifications\Endpoints;


use Pina\App;
use Pina\Controls\RecordForm;
use Pina\Controls\SidebarWrapper;
use Pina\Data\DataRecord;
use Pina\Data\Schema;
use Pina\Http\Endpoint;
use Pina\Response;
use Pina\Types\StringType;
use PinaNotifications\Recipients\UserRecipient;
use PinaNotifications\Messages\Message;
use PinaNotifications\Transports\TransportRegistry;
use PinaNotifications\Types\TransportType;

class NotificationTestEndpoint extends Endpoint
{

    protected function getSchema(): Schema
    {
        $schema = new Schema();
        $schema->add('transport', 'Transport', TransportType::class);
        $schema->add('address', 'Address', StringType::class);
        $schema->add('title', 'Title', StringType::class);
        $schema->add('text', 'Text', StringType::class);
        $schema->add('link', 'Link', StringType::class);
        return $schema;
    }

    public function index()
    {
        $record = new DataRecord([], $this->getSchema());

        /** @var RecordForm $form */
        $form = App::make(RecordForm::class);
        $form->setMethod('post');
        $form->load($record);

        return $form->wrap(App::make(SidebarWrapper::class));
    }

    public function store()
    {
        $data = $this->request()->all();
        $normalized = $this->getSchema()->normalize($data);

        $message = new Message($normalized['title'], $normalized['text'], $normalized['link']);

        $transport = $normalized['transport'];
        $address = $normalized['address'];
        if ($transport) {
            TransportRegistry::get($transport)->send($address, $message);
            return Response::ok();
        }

        $recipient = new UserRecipient($address);
        $recipient->notify($message);

        return Response::ok();
    }

}