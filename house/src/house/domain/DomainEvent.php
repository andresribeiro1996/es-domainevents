<?php

namespace App\house\domain;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Contracts\EventDispatcher\Event;

abstract class DomainEvent extends Event
{
    public const SCOPE_LOCAL = 'local';

    public const SCOPE_GLOBAL = 'global';

    private const BC_NAME = 'house';

    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $aggregateName;

    /**
     * @var int
     */
    private $aggregateId;

    private $version;

    /**
     * @var string
     */
    private $scope;

    /**
     * @var DateTimeImmutable
     */
    private $occurredOn;

    /**
     * DomainEvent constructor.
     * @param string $name
     * @param int $entityId
     * @param string $type
     * @param string $scope
     */
    public function __construct(string $name, int $entityId, string $type, string $scope)
    {
        $this->id = Uuid::getFactory()->fromInteger((string)$entityId);
        $this->name = strtolower($name);
        $this->aggregateId = $entityId;
        $this->aggregateName = $type;
        $this->scope = $scope;
        $this->occurredOn = new DateTimeImmutable();
    }

    public function getData(): array {
        return [
            'bc_name' => self::BC_NAME,
            'event_id' => $this->id,
            'event_name' => $this->name,
            'aggregate_id' => $this->aggregateId,
            'aggregate_name' => $this->aggregateName,
            'version' => $this->version,
            'occurred_on' => $this->occurredOn->format('Y-m-d H:i:s')
        ];
    }

    public function getBoundedContextName(): string {
        return self::BC_NAME;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function getAggregateName(): string
    {
        return $this->aggregateName;
    }

    public function getAggregateId(): int
    {
        return $this->aggregateId;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function isGlobalEvent(): bool
    {
        return $this->scope === self::SCOPE_GLOBAL;
    }


}