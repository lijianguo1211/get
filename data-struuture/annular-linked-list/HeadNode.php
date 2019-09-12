<?php


class HeadNode
{
    public $id;

    public $uuid;

    public $next;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getNext()
    {
        return $this->next;
    }

    public function setNext()
    {

    }
}