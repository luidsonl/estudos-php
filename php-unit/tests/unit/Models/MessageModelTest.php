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
            senderId: Faker::create()->uuid(),
            receiverId: Faker::create()->uuid(),
            topicId: Faker::create()->uuid(),
            content: Faker::create()->text(),
            timestamp: Faker::create()->dateTime()
        );

        $this->assertInstanceOf(Message::class, $message);
        $this->assertIsString($message->id);
        $this->assertIsString($message->content);
        $this->assertIsString($message->senderId);
        $this->assertIsString($message->receiverId);
        $this->assertIsString($message->topicId);
        $this->assertInstanceOf(\DateTime::class, $message->timestamp);
    }

    public function testMessageWithEmptyContentShouldFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new Message(
            id: Faker::create()->uuid(),
            senderId: Faker::create()->uuid(),
            receiverId: Faker::create()->uuid(),
            topicId: Faker::create()->uuid(),
            content: '',
            timestamp: Faker::create()->dateTime()
        );
    }


    public function testMessageWithEmptyIdShouldFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new Message(
            id: '',
            senderId: Faker::create()->uuid(),
            receiverId: Faker::create()->uuid(),
            topicId: Faker::create()->uuid(),
            content: Faker::create()->text(),
            timestamp: Faker::create()->dateTime()
        );
    }

    public function testMessageWithEmptySenderIdShouldFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new Message(
            id: Faker::create()->uuid(),
            senderId: '',
            receiverId: Faker::create()->uuid(),
            topicId: Faker::create()->uuid(),
            content: Faker::create()->text(),
            timestamp: Faker::create()->dateTime()
        );
    }

    public function testMessageWithEmptyReceiverIdShouldFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new Message(
            id: Faker::create()->uuid(),
            senderId: Faker::create()->uuid(),
            receiverId: '',
            topicId: Faker::create()->uuid(),
            content: Faker::create()->text(),
            timestamp: Faker::create()->dateTime()
        );
    }

    public function testMessageWithEmptyTopicIdShouldFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new Message(
            id: Faker::create()->uuid(),
            senderId: Faker::create()->uuid(),
            receiverId: Faker::create()->uuid(),
            topicId: '',
            content: Faker::create()->text(),
            timestamp: Faker::create()->dateTime()
        );
    }

    public function testMessageWithVeryLongContent()
    {
        $longContent = str_repeat('a', 10000); // 10k characters
        
        $message = new Message(
            id: Faker::create()->uuid(),
            senderId: Faker::create()->uuid(),
            receiverId: Faker::create()->uuid(),
            topicId: Faker::create()->uuid(),
            content: $longContent,
            timestamp: Faker::create()->dateTime()
        );

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals($longContent, $message->content);
    }

    public function testMessageWithMinimalContent()
    {
        $minimalContent = 'a';
        
        $message = new Message(
            id: Faker::create()->uuid(),
            senderId: Faker::create()->uuid(),
            receiverId: Faker::create()->uuid(),
            topicId: Faker::create()->uuid(),
            content: $minimalContent,
            timestamp: Faker::create()->dateTime()
        );

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals($minimalContent, $message->content);
    }

    public function testMessageTimestampIsImmutable()
    {
        $originalDate = Faker::create()->dateTime();
        $message = new Message(
            id: Faker::create()->uuid(),
            senderId: Faker::create()->uuid(),
            receiverId: Faker::create()->uuid(),
            topicId: Faker::create()->uuid(),
            content: Faker::create()->text(),
            timestamp: $originalDate
        );

        $originalDate->modify('+1 day');
        
        $this->assertNotEquals($originalDate, $message->timestamp);
    }

    public function testMessageWithSameSenderAndReceiverShouldWork()
    {
        $sameId = Faker::create()->uuid();
        
        $message = new Message(
            id: Faker::create()->uuid(),
            senderId: $sameId,
            receiverId: $sameId,
            topicId: Faker::create()->uuid(),
            content: Faker::create()->text(),
            timestamp: Faker::create()->dateTime()
        );

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals($sameId, $message->senderId);
        $this->assertEquals($sameId, $message->receiverId);
    }

    public function testMessageIdsAreProperUUIDs()
    {
        $uuid = Faker::create()->uuid();
        
        $message = new Message(
            id: $uuid,
            senderId: Faker::create()->uuid(),
            receiverId: Faker::create()->uuid(),
            topicId: Faker::create()->uuid(),
            content: Faker::create()->text(),
            timestamp: Faker::create()->dateTime()
        );

        $this->assertMatchesRegularExpression(
            '/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i',
            $message->id
        );
    }

}