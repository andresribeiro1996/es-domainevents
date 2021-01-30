<?php

namespace App\robber\domain;

/**
 * @template T
 * @template TID
 * Class AggregateRoot
 */
abstract class AggregateRoot
{
    /**
     * @psalm-return TID
     */
    abstract public function getId();

    public function serialize(): array 
    {
        return json_decode(json_encode($this), true);
    }

    /**
     * @param DomainEvent[] $domainEventList
     */
    public function apply(array $domainEventList)
    {
        foreach ($domainEventList as $domainEvent) {
            foreach (get_class_methods(get_class($this)) as $methodName) {
                $resolvedMethodName = substr($methodName, 5);

                if(strtolower($resolvedMethodName) === strtolower($domainEvent->getName())) {
                    call_user_func([$this, $methodName], $domainEvent);
                    break;
                }
            }
        }
    }
}