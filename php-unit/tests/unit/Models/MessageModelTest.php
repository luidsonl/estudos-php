<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Faker\Factory as Faker;

use App\Models\Message;

final class MessageModelTest extends TestCase
{
    public function testMessage()
    {
        $message = new Message(
            id: Faker::create()->uuid(),
            content: Faker::create()->text(),
            senderId: Faker::create()->uuid(),
            receiverId: Faker::create()->uuid(),
            timestamp: Faker::create()->dateTime()
        );

        $this->assertInstanceOf(Message::class, $message);
        $this->assertIsString($message->id);
        $this->assertIsString($message->content);
        $this->assertIsString($message->senderId);
        $this->assertIsString($message->receiverId);
        $this->assertInstanceOf(\DateTime::class, $message->timestamp);
    }
}