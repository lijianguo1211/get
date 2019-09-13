<?php


class HeadNode
{
    public $id;

    public $uuid;

    public $next;

    public function __construct(int $id, string $uuid)
    {
        $this->id = $id;
        $this->uuid = $uuid;
    }

    public function getNum()
    {
        return $this->id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getNext()
    {
        return $this->next;
    }

    public function setNext(HeadNode $next)
    {
        $this->next = $next;
    }
}