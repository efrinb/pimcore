<?php

namespace LogBundle\Model;

use DateTime;
use Pimcore\Model\AbstractModel;
use Pimcore\Model\Exception\NotFoundException;

class Activity extends AbstractModel
{
    public ?int $id = null;
    public ?int $userId;
    public mixed $timestamp;
    public ?string $action;

    public static function getById(int $id): ?Activity
    {
        try {
            $obj = new self;
            $obj->getDao()->getById($id);
            return $obj;
        }
        catch (NotFoundException $ex) {
            \Pimcore\Logger::warn("Activity with id $id not found");
        }

        return null;
    }

    public static function create(?int $userId, ?string $action, ?\DateTime $timestamp): Activity
    {
        $activity = new self();
        $activity->setUserId($userId);
        $activity->setAction($action);
        $activity->setTimestamp($timestamp);
        return $activity;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getTimestamp(): mixed
    {
        return $this->timestamp;
    }

    public function setTimestamp(mixed $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
