<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\Aggregate;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Event\DomainEvent;
use DateTimeImmutable;
use Override;

final class TestDomainEvent implements DomainEvent
{
    public function occurredOn(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
    
    public function eventName(): string
    {
        return 'test.domain.event';
    }
}

final class TestAggregate extends AggregateRoot
{
    public function addRecord(): void
    {
        $this->record(new TestDomainEvent());
    }
}

final class AggregateRootTest extends \PHPUnit\Framework\TestCase
{
    public function testPullDomainEventsReturnsEmptyArrayWhenNoEventsRecorded(): void
    {
        $aggregateRoot = new TestAggregate();
        $aggregateRoot->addRecord();

        $events = $aggregateRoot->pullDomainEvents();

        $this->assertIsArray($events);
        $this->assertCount(1, $events);
    }
}