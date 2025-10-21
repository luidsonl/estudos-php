<?php
namespace Tests;
use PHPUnit\Framework\TestCase;
use Faker\Factory as Faker;
use App\Models\Topic;
use App\Enums\Subjects;

final class TopicModelTest extends TestCase
{
    public function testTopicCreationWithValidData()
    {
        $topic = new Topic(
            title: Faker::create()->sentence(),
            subjects: [Subjects::MATH, Subjects::SCIENCE]
        );

        $this->assertInstanceOf(Topic::class, $topic);
        $this->assertIsString($topic->title);
        $this->assertIsArray($topic->subjects);
        
        foreach ($topic->subjects as $subject) {
            $this->assertInstanceOf(Subjects::class, $subject);
            $this->assertIsString($subject->value);
        }
    }

    public function testTopicCreationWithEmptySubjects()
    {
        $topic = new Topic(
            title: Faker::create()->sentence(),
            subjects: []
        );

        $this->assertInstanceOf(Topic::class, $topic);
        $this->assertIsString($topic->title);
        $this->assertIsArray($topic->subjects);
        $this->assertEmpty($topic->subjects);
    }

    public function testTopicCreationWithSingleSubject()
    {
        $topic = new Topic(
            title: Faker::create()->sentence(),
            subjects: [Subjects::HISTORY]
        );

        $this->assertInstanceOf(Topic::class, $topic);
        $this->assertCount(1, $topic->subjects);
        $this->assertEquals(Subjects::HISTORY, $topic->subjects[0]);
    }

    public function testTopicCreationWithAllSubjects()
    {
        $topic = new Topic(
            title: Faker::create()->sentence(),
            subjects: Subjects::cases()
        );

        $this->assertInstanceOf(Topic::class, $topic);
        $this->assertCount(4, $topic->subjects);
    }

    public function testTopicCreationWithInvalidSubjectType()
    {
        
        $this->expectException(\InvalidArgumentException::class);
        
        $topic = new Topic(
            title: Faker::create()->sentence(),
            subjects: ['invalid_string', 123, null]
        );
    }

    public function testTopicCreationWithDuplicateSubjects()
    {
        $topic = new Topic(
            title: Faker::create()->sentence(),
            subjects: [Subjects::MATH, Subjects::MATH, Subjects::SCIENCE]
        );

        $this->assertInstanceOf(Topic::class, $topic);
        $this->assertCount(3, $topic->subjects);
        $this->assertEquals(Subjects::MATH, $topic->subjects[0]);
        $this->assertEquals(Subjects::MATH, $topic->subjects[1]);
    }

    public function testTopicCreationWithEmptyTitle()
    {
        $topic = new Topic(
            title: '',
            subjects: [Subjects::LITERATURE]
        );

        $this->assertInstanceOf(Topic::class, $topic);
        $this->assertEquals('', $topic->title);
    }


    public function testTopicSubjectValuesAreCorrect()
    {
        $topic = new Topic(
            title: "Test Topic",
            subjects: [Subjects::MATH, Subjects::SCIENCE, Subjects::HISTORY]
        );

        $expectedValues = ['math', 'science', 'history'];
        $actualValues = array_map(fn($subject) => $subject->value, $topic->subjects);

        $this->assertEquals($expectedValues, $actualValues);
    }

    public function testTopicSubjectNamesAreCorrect()
    {
        $topic = new Topic(
            title: "Test Topic",
            subjects: [Subjects::LITERATURE, Subjects::MATH]
        );

        $expectedNames = ['LITERATURE', 'MATH'];
        $actualNames = array_map(fn($subject) => $subject->name, $topic->subjects);

        $this->assertEquals($expectedNames, $actualNames);
    }

    public function testTopicWithoutSubjectsParameter()
    {
        $topic = new Topic(
            title: Faker::create()->sentence()
        );

        $this->assertInstanceOf(Topic::class, $topic);
        $this->assertIsArray($topic->subjects);
        $this->assertEmpty($topic->subjects);
    }
}