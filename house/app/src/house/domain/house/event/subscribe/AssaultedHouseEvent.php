<?php
namespace App\house\domain\house\event\subscribe;


use App\house\domain\DomainEvent;

final class AssaultedHouseEvent extends DomainEvent
{
    public const TYPE = 'robber';
    public const NAME = 'assaultedhouseevent';
    protected $robberLevel;
    protected $houseId;
    protected $robberId;

    public function __construct(int $robberId, int $robberLevel, int $houseId, string $scope = self::SCOPE_LOCAL)
    {
        $this->robberLevel = $robberLevel;
        $this->houseId = $houseId;
        $this->robberId = $robberId;
        parent::__construct(self::NAME, $robberId,self::TYPE, $scope);
    }

    public function getRobberLevel(): int
    {
        return $this->robberLevel;
    }

    public function getHouseId(): int
    {
        return $this->houseId;
    }

    public function getRobberId(): int
    {
        return $this->robberId;
    }

    public function getData(): array
    {
        return array_merge(parent::getData(), ['robber_id' => $this->robberId, 'robber_level' => $this->robberLevel, 'house_id' => $this->houseId]);
    }


}